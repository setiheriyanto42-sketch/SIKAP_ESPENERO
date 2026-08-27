<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use App\Services\AIParserService;
use App\Services\ModulAjarSaveService;
use Throwable;

class UploadModulAjarController extends Controller
{
    /**
     * Form upload RPP / Modul Ajar.
     */
    public function create()
    {
        return view('modul_ajar.upload');
    }


    /**
     * Proses upload sementara.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ], [
            'dokumen.required' =>
                'Silakan pilih dokumen RPP / Modul Ajar.',

            'dokumen.mimes' =>
                'Dokumen harus berformat PDF, DOC, atau DOCX.',

            'dokumen.max' =>
                'Ukuran dokumen maksimal 10 MB.',
        ]);

        $file = $request->file('dokumen');


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILE SEMENTARA
        |--------------------------------------------------------------------------
        */

        $path = $file->store(
            'modul-ajar/temp/' . auth()->id(),
            'local'
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN INFORMASI KE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'upload_modul_ajar' => [

                'path' => $path,

                'nama_asli' =>
                    $file->getClientOriginalName(),

                'mime' =>
                    $file->getMimeType(),

                'ukuran' =>
                    $file->getSize(),

                'extension' =>
                    strtolower(
                        $file->getClientOriginalExtension()
                    ),

                'status' =>
                    'uploaded',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | HAPUS HASIL ANALISIS LAMA
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'analisis_modul_ajar'
        );


        return redirect()
            ->route('modul-ajar.upload.preview')
            ->with(
                'success',
                'Dokumen berhasil diunggah. Silakan periksa dokumen sebelum diproses.'
            );
    }


    /**
     * Preview dokumen sebelum dianalisis.
     */
    public function preview()
    {
        $dokumen = session(
            'upload_modul_ajar'
        );


        if (!$dokumen) {

            return redirect()
                ->route('modul-ajar.upload')
                ->with(
                    'error',
                    'Belum ada dokumen yang diunggah.'
                );
        }


        return view(
            'modul_ajar.upload-preview',
            compact('dokumen')
        );
    }


    /**
     * Membaca dan menganalisis dokumen.
     */
    public function analyze()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SESSION UPLOAD
        |--------------------------------------------------------------------------
        */

        $dokumen = session(
            'upload_modul_ajar'
        );


        if (!$dokumen) {

            return redirect()
                ->route('modul-ajar.upload')
                ->with(
                    'error',
                    'Dokumen tidak ditemukan. Silakan upload kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK FILE
        |--------------------------------------------------------------------------
        */

        if (
            !isset($dokumen['path']) ||
            !Storage::disk('local')
                ->exists($dokumen['path'])
        ) {

            session()->forget(
                'upload_modul_ajar'
            );

            session()->forget(
                'analisis_modul_ajar'
            );


            return redirect()
                ->route('modul-ajar.upload')
                ->with(
                    'error',
                    'File dokumen tidak ditemukan pada penyimpanan sementara.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LOKASI FILE FISIK
        |--------------------------------------------------------------------------
        */

        $fullPath =
            Storage::disk('local')
                ->path($dokumen['path']);


        /*
        |--------------------------------------------------------------------------
        | EXTENSION
        |--------------------------------------------------------------------------
        */

        $extension =
            $dokumen['extension']
            ??
            strtolower(
                pathinfo(
                    $dokumen['nama_asli'],
                    PATHINFO_EXTENSION
                )
            );


        /*
        |--------------------------------------------------------------------------
        | TEXT HASIL PEMBACAAN
        |--------------------------------------------------------------------------
        */

        $text = '';


        try {

            /*
            |--------------------------------------------------------------------------
            | PDF
            |--------------------------------------------------------------------------
            */

            if ($extension === 'pdf') {

                $parser = new Parser();

                $pdf =
                    $parser->parseFile(
                        $fullPath
                    );

                $text =
                    $pdf->getText();
            }


            /*
            |--------------------------------------------------------------------------
            | DOCX
            |--------------------------------------------------------------------------
            */

            elseif ($extension === 'docx') {

                $text =
                    $this->extractDocxText(
                        $fullPath
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | DOC LAMA
            |--------------------------------------------------------------------------
            */

            elseif ($extension === 'doc') {

                return redirect()
                    ->route(
                        'modul-ajar.upload.preview'
                    )
                    ->with(
                        'error',
                        'Format DOC lama belum dapat dianalisis otomatis. Silakan simpan dokumen menjadi DOCX atau PDF lalu upload kembali.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | FORMAT LAIN
            |--------------------------------------------------------------------------
            */

            else {

                return redirect()
                    ->route(
                        'modul-ajar.upload.preview'
                    )
                    ->with(
                        'error',
                        'Format dokumen tidak didukung untuk proses analisis.'
                    );
            }

        } catch (Throwable $e) {

            report($e);


            return redirect()
                ->route(
                    'modul-ajar.upload.preview'
                )
                ->with(
                    'error',
                    'Dokumen gagal dibaca. Pastikan file PDF/DOCX tidak rusak dan bukan dokumen yang diproteksi.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN TEXT
        |--------------------------------------------------------------------------
        */

        $text =
            $this->cleanText(
                $text
            );


        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH TEXT BERHASIL DIBACA
        |--------------------------------------------------------------------------
        */

        if (mb_strlen($text) < 50) {

            return redirect()
                ->route(
                    'modul-ajar.upload.preview'
                )
                ->with(
                    'error',
                    'Isi dokumen belum berhasil dibaca sebagai teks. PDF mungkin berupa hasil scan/gambar dan nantinya memerlukan OCR.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ANALISIS DASAR
        |--------------------------------------------------------------------------
        |
        | Tahap pertama:
        | sistem mulai mengenali struktur dokumen.
        |
        | Nanti parser ini kita tingkatkan lagi agar:
        |
        | Modul
        |   -> BAB
        |       -> Pertemuan
        |
        |--------------------------------------------------------------------------
        */

       $hasil = $this->analyzeText($text);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN HASIL ANALISIS KE SESSION
        |--------------------------------------------------------------------------
        */

        session([

            'analisis_modul_ajar' => [

                'dokumen' => [
                    'nama_asli' =>
                        $dokumen['nama_asli'],

                    'mime' =>
                        $dokumen['mime'],

                    'ukuran' =>
                        $dokumen['ukuran'],

                    'extension' =>
                        $extension,
                ],

                'hasil' =>
                    $hasil,

                'text' =>
                    $text,
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS UPLOAD
        |--------------------------------------------------------------------------
        */

        $dokumen['status'] =
            'sudah_dianalisis';


        session([
            'upload_modul_ajar' =>
                $dokumen
        ]);


        /*
        |--------------------------------------------------------------------------
        | TAHAP SEMENTARA
        |--------------------------------------------------------------------------
        |
        | Karena halaman hasil analisis belum kita buat,
        | untuk sekarang kita kembali ke preview.
        |
        | Setelah tahap ini berhasil, kita buat:
        |
        | modul_ajar.upload-analysis
        |
        |--------------------------------------------------------------------------
        */

        return redirect()
        ->route('modul-ajar.upload.analysis')
        ->with(
            'success',
            'Dokumen berhasil dibaca dan dianalisis. Silakan periksa hasil analisis RPP sebelum disimpan ke Modul Ajar.'
        );
    }


    /**
     * Membaca DOCX.
     */
    private function extractDocxText(
        string $path
    ): string {

        /*
        |--------------------------------------------------------------------------
        | DOCX SEBENARNYA FILE ZIP
        |--------------------------------------------------------------------------
        */

        $zip =
            new \ZipArchive();


        if (
            $zip->open($path)
            !== true
        ) {

            return '';
        }


        /*
        |--------------------------------------------------------------------------
        | ISI UTAMA WORD
        |--------------------------------------------------------------------------
        */

        $xml =
            $zip->getFromName(
                'word/document.xml'
            );


        $zip->close();


        if (!$xml) {

            return '';
        }


        /*
        |--------------------------------------------------------------------------
        | TAMBAHKAN PEMISAH
        |--------------------------------------------------------------------------
        */

        $xml =
            str_replace(
                [
                    '</w:p>',
                    '</w:tr>',
                    '<w:tab/>',
                ],
                [
                    "\n",
                    "\n",
                    "\t",
                ],
                $xml
            );


        /*
        |--------------------------------------------------------------------------
        | HAPUS TAG XML
        |--------------------------------------------------------------------------
        */

        $text =
            strip_tags(
                $xml
            );


        return html_entity_decode(
            $text,
            ENT_QUOTES | ENT_XML1,
            'UTF-8'
        );
    }


    /**
     * Membersihkan hasil ekstraksi text.
     */
    private function cleanText(
        string $text
    ): string {

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI BARIS
        |--------------------------------------------------------------------------
        */

        $text =
            str_replace(
                [
                    "\r\n",
                    "\r",
                ],
                "\n",
                $text
            );


        /*
        |--------------------------------------------------------------------------
        | HAPUS SPASI BERLEBIHAN
        |--------------------------------------------------------------------------
        */

        $text =
            preg_replace(
                '/[ \t]+/',
                ' ',
                $text
            );


        /*
        |--------------------------------------------------------------------------
        | HAPUS BARIS KOSONG BERLEBIHAN
        |--------------------------------------------------------------------------
        */

        $text =
            preg_replace(
                "/\n{3,}/",
                "\n\n",
                $text
            );


        return trim(
            $text
        );
    }


    /**
     * Analisis awal isi RPP.
     */
    private function analyzeText(
        string $text
    ): array {

        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        $hasil = [

            'mata_pelajaran' =>
                null,

            'kelas' =>
                null,

            'fase' =>
                null,

            'semester' =>
                null,

            'bab' =>
                [],

            'indikator' => [

                'tujuan_pembelajaran' =>
                    false,

                'materi' =>
                    false,

                'asesmen' =>
                    false,

                'kegiatan_pembelajaran' =>
                    false,

                'pertemuan' =>
                    false,
            ],
        ];

        


        /*
        |--------------------------------------------------------------------------
        | MATA PELAJARAN
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/mata\s*pelajaran\s*[:\-]?\s*([^\n]+)/iu',
                $text,
                $match
            )
        ) {

            $hasil['mata_pelajaran'] =
                trim(
                    $match[1]
                );
        }


        /*
        |--------------------------------------------------------------------------
        | KELAS
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/kelas\s*[:\/\-]?\s*(VII|VIII|IX|7|8|9)\b/iu',
                $text,
                $match
            )
        ) {

            $hasil['kelas'] =
                strtoupper(
                    trim(
                        $match[1]
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FASE
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/fase\s*[:\-]?\s*([A-F])/iu',
                $text,
                $match
            )
        ) {

            $hasil['fase'] =
                strtoupper(
                    $match[1]
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SEMESTER
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/semester\s*[:\-]?\s*(ganjil|genap|1|2)/iu',
                $text,
                $match
            )
        ) {

            $semester =
                strtolower(
                    $match[1]
                );


            if (
                $semester === '1'
            ) {

                $semester =
                    'Ganjil';

            } elseif (
                $semester === '2'
            ) {

                $semester =
                    'Genap';

            } else {

                $semester =
                    ucfirst(
                        $semester
                    );
            }


            $hasil['semester'] =
                $semester;
        }


        /*
        |--------------------------------------------------------------------------
        | INDIKATOR STRUKTUR
        |--------------------------------------------------------------------------
        */

        $hasil['indikator']
            ['tujuan_pembelajaran'] =

            preg_match(
                '/tujuan\s+pembelajaran/iu',
                $text
            ) === 1;


        $hasil['indikator']
            ['materi'] =

            preg_match(
                '/materi(\s+pembelajaran)?/iu',
                $text
            ) === 1;


        $hasil['indikator']
            ['asesmen'] =

            preg_match(
                '/asesmen|penilaian/iu',
                $text
            ) === 1;


        $hasil['indikator']
            ['kegiatan_pembelajaran'] =

            preg_match(
                '/kegiatan\s+pembelajaran|kegiatan\s+inti/iu',
                $text
            ) === 1;


        $hasil['indikator']
            ['pertemuan'] =

            preg_match(
                '/pertemuan\s*(ke[\-\s]*)?\d+/iu',
                $text
            ) === 1;


        /*
        |--------------------------------------------------------------------------
        | DETEKSI BAB
        |--------------------------------------------------------------------------
        */

        preg_match_all(
            '/^\s*BAB\s+(I|II|III|IV|V|VI|VII|VIII|IX|X|[0-9]+)\s*[:.\-]?\s*(.+)$/imu',
            $text,
            $babMatches,
            PREG_SET_ORDER
        );
           

        foreach (
            $babMatches as $bab
        ) {

            $hasil['bab'][] = [

                'nomor' =>
                    trim(
                        $bab[1]
                    ),

                'judul' =>
                    trim(
                        $bab[2]
                    ),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $hasil['statistik'] = [

            'jumlah_karakter' =>
                mb_strlen(
                    $text
                ),

            'jumlah_kata' =>
                str_word_count(
                    strip_tags($text)
                ),

            'jumlah_bab_terdeteksi' =>
                count(
                    $hasil['bab']
                ),
        ];


        return $hasil;
    }

    /**
     * Menampilkan hasil analisis dokumen RPP.
     */
    public function analysis()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SESSION HASIL ANALISIS
        |--------------------------------------------------------------------------
        */

        $analisis = session('analisis_modul_ajar');

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN HASIL ANALISIS ADA
        |--------------------------------------------------------------------------
        */

        if (!$analisis) {

            return redirect()
                ->route('modul-ajar.upload.preview')
                ->with(
                    'error',
                    'Dokumen belum dianalisis. Silakan klik Periksa & Analisis Dokumen terlebih dahulu.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN TEKS HASIL PARSER ADA
        |--------------------------------------------------------------------------
        */

        if (
            empty($analisis['text']) ||
            mb_strlen($analisis['text']) < 50
        ) {

            return redirect()
                ->route('modul-ajar.upload.preview')
                ->with(
                    'error',
                    'Isi dokumen belum berhasil dibaca. Silakan lakukan pemeriksaan dokumen terlebih dahulu.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA DOKUMEN
        |--------------------------------------------------------------------------
        */

        $dokumen = $analisis['dokumen'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | HASIL ANALISIS
        |--------------------------------------------------------------------------
        |
        | analyze() sebelumnya sudah menjalankan:
        |
        | $hasil = $this->analyzeText($text);
        |
        | Jadi JANGAN analisis ulang di sini.
        |--------------------------------------------------------------------------
        */

        $hasilAnalisis = $analisis['hasil'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK VIEW
        |--------------------------------------------------------------------------
        */

        $hasil = [
            'nama_file' => $dokumen['nama_asli'] ?? '-',

            'jumlah_karakter' =>
                mb_strlen($analisis['text']),

            'teks' =>
                $analisis['text'],

            'analisis' =>
                $hasilAnalisis,
        ];

        /*
        |--------------------------------------------------------------------------
        | AMBIL HASIL IDENTIFIKASI STRUKTUR RPP
        |--------------------------------------------------------------------------
        |
        | Data ini dibuat oleh method structure().
        | Jika guru belum menekan Susun Struktur RPP,
        | nilainya masih null.
        |
        */

        $strukturSession = session('struktur_modul_ajar');

        $struktur = $strukturSession['struktur'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN HASIL ANALISIS
        |--------------------------------------------------------------------------
        */

        return view(
            'modul_ajar.upload-analysis',
            compact(
                'dokumen',
                'hasil',
                'struktur'
            )
        );
    }

    public function structure()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL HASIL ANALISIS DOKUMEN
        |--------------------------------------------------------------------------
        */

        $analisis = session('analisis_modul_ajar');

        if (
            !$analisis ||
            empty($analisis['text'])
        ) {

            return redirect()
                ->route('modul-ajar.upload.preview')
                ->with(
                    'error',
                    'Hasil pembacaan dokumen tidak ditemukan. Silakan analisis dokumen kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TEXT HASIL PARSER
        |--------------------------------------------------------------------------
        */

        $text = $analisis['text'];


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI TEXT
        |--------------------------------------------------------------------------
        */

        $normalized = preg_replace(
            "/[ \t]+/",
            " ",
            $text
        );

        $normalized = preg_replace(
            "/\r\n|\r/",
            "\n",
            $normalized
        );

        $normalized = preg_replace(
            "/\n{3,}/",
            "\n\n",
            $normalized
        );

        $normalized = trim($normalized);

        /*
        |--------------------------------------------------------------------------
        | PARSER AI
        |--------------------------------------------------------------------------
        */

        $parser = new AIParserService();

        $hasilParser = $parser->parse($normalized);
        $metadata =
        $hasilParser['metadata'] ?? [];

        $daftarBab = $hasilParser['bab'] ?? [];

        

        
        /*
        |--------------------------------------------------------------------------
        | STRUKTUR AWAL
        |--------------------------------------------------------------------------
        */

        $struktur = [

            'mata_pelajaran'=>

                $metadata['mata_pelajaran'] ?? null,

            'kelas'=>

                $metadata['kelas'] ?? null,

            'fase'=>

                $metadata['fase'] ?? null,

            'semester'=>

                $metadata['semester'] ?? null,

            'tahun_ajaran'=>

                $metadata['tahun_ajaran'] ?? null,

            'alokasi_waktu'=>

                $metadata['alokasi_waktu'] ?? null,

            'bab'=>

                $daftarBab

        ];


        /*
        |--------------------------------------------------------------------------
        | DETEKSI MATA PELAJARAN
        |--------------------------------------------------------------------------
        */

        $daftarMapel = [

            'Informatika',

            'Matematika',

            'Bahasa Indonesia',

            'Bahasa Inggris',

            'Ilmu Pengetahuan Alam',

            'IPA',

            'Ilmu Pengetahuan Sosial',

            'IPS',

            'Pendidikan Pancasila',

            'Pendidikan Agama',

            'PJOK',

            'Seni Budaya',

            'Bahasa Jawa',

        ];

        foreach ($daftarMapel as $mapel) {

            if (
                stripos(
                    $normalized,
                    $mapel
                ) !== false
            ) {

                $struktur['mata_pelajaran'] =
                    $mapel;

                break;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DETEKSI KELAS
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/kelas\s*(VII|VIII|IX|7|8|9)\b/i',
                $normalized,
                $match
            )
        ) {

            $kelas = strtoupper(
                $match[1]
            );

            $konversiKelas = [

                'VII' => '7',

                'VIII' => '8',

                'IX' => '9',

            ];

            $struktur['kelas'] =
                $konversiKelas[$kelas]
                ??
                $kelas;
        }


        /*
        |--------------------------------------------------------------------------
        | DETEKSI FASE
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/fase\s*[:\-]?\s*([A-F])/i',
                $normalized,
                $match
            )
        ) {

            $struktur['fase'] =
                strtoupper(
                    $match[1]
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DETEKSI SEMESTER
        |--------------------------------------------------------------------------
        |
        | Mendukung beberapa format:
        |
        | Semester : Ganjil
        | Semester : 1
        | Semester : I
        | Semester : I (Ganjil)
        | VIII (Delapan) / I (Ganjil)
        | Kelas / Semester : VIII / I
        |
        */

        if (
            preg_match(
                '/semester\s*[:\-]?\s*(ganjil|genap|1|2|I{1,2})(?:\s*\((ganjil|genap)\))?/i',
                $normalized,
                $match
            )
        ) {

            $semesterUtama =
                strtolower(trim($match[1]));

            $semesterKeterangan =
                isset($match[2])
                    ? strtolower(trim($match[2]))
                    : null;

            if ($semesterKeterangan === 'ganjil') {

                $struktur['semester'] = 'Ganjil';

            } elseif ($semesterKeterangan === 'genap') {

                $struktur['semester'] = 'Genap';

            } elseif (
                in_array(
                    $semesterUtama,
                    ['ganjil', '1', 'i']
                )
            ) {

                $struktur['semester'] = 'Ganjil';

            } elseif (
                in_array(
                    $semesterUtama,
                    ['genap', '2', 'ii']
                )
            ) {

                $struktur['semester'] = 'Genap';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK SEMESTER
        |--------------------------------------------------------------------------
        |
        | Beberapa RPP menulis:
        |
        | VIII (Delapan) / I (Ganjil)
        | VIII / I
        |
        | tanpa menulis kata "Semester" secara langsung.
        |
        */

        if (
            empty($struktur['semester']) &&
            preg_match(
                '/(?:VII|VIII|IX|7|8|9)(?:\s*\([^)]+\))?\s*\/\s*(I{1,2}|1|2)(?:\s*\((ganjil|genap)\))?/i',
                $normalized,
                $match
            )
        ) {

            $semesterUtama =
                strtolower(trim($match[1]));

            $semesterKeterangan =
                isset($match[2])
                    ? strtolower(trim($match[2]))
                    : null;

            if ($semesterKeterangan === 'ganjil') {

                $struktur['semester'] = 'Ganjil';

            } elseif ($semesterKeterangan === 'genap') {

                $struktur['semester'] = 'Genap';

            } elseif (
                in_array(
                    $semesterUtama,
                    ['i', '1']
                )
            ) {

                $struktur['semester'] = 'Ganjil';

            } elseif (
                in_array(
                    $semesterUtama,
                    ['ii', '2']
                )
            ) {

                $struktur['semester'] = 'Genap';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DETEKSI TAHUN AJARAN / TAHUN PELAJARAN
        |--------------------------------------------------------------------------
        |
        | Mendukung:
        |
        | Tahun Ajaran : 2026/2027
        | Tahun Pelajaran : 2026/2027
        | Tahun Ajaran 2026 - 2027
        | TP 2026/2027
        | 2026/2027
        |
        */

        if (
            preg_match(
                '/(?:tahun\s+(?:ajaran|pelajaran)|tahun\s+pelajaran|tp)\s*[:\-]?\s*(\d{4})\s*[\/\-]\s*(\d{4})/i',
                $normalized,
                $match
            )
        ) {

            $struktur['tahun_ajaran'] =
                $match[1] . '/' . $match[2];

        } elseif (
            preg_match(
                '/\b(20\d{2})\s*[\/\-]\s*(20\d{2})\b/',
                $normalized,
                $match
            )
        ) {

            $struktur['tahun_ajaran'] =
                $match[1] . '/' . $match[2];
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN STRUKTUR KE SESSION
        |--------------------------------------------------------------------------
        |
        | BELUM MASUK DATABASE.
        |
        */

        session([

            'struktur_modul_ajar' => [

                'struktur' =>
                    $struktur,

                'text' =>
                    $normalized,

                'dokumen' =>
                    $analisis['dokumen'] ?? [],

            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UNTUK TAHAP PERTAMA
        |--------------------------------------------------------------------------
        |
        | Kita kembali ke halaman analysis dan nanti menampilkan
        | hasil identifikasi di sana.
        |
        */

        return view(
            'modul_ajar.upload-structure',
            [
                'struktur' => $struktur,
                'dokumen'  => $analisis['dokumen'] ?? [],
            ]
        );
    }

    /**
     * Batalkan upload.
     */
    public function cancel()
    {
        $dokumen =
            session(
                'upload_modul_ajar'
            );


        if (
            $dokumen &&
            isset($dokumen['path'])
        ) {

            if (
                Storage::disk('local')
                    ->exists(
                        $dokumen['path']
                    )
            ) {

                Storage::disk('local')
                    ->delete(
                        $dokumen['path']
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'upload_modul_ajar'
        );

        session()->forget(
            'analisis_modul_ajar'
        );


        return redirect()
            ->route(
                'modul-ajar.index'
            )
            ->with(
                'success',
                'Upload dokumen dibatalkan.'
            );
    }

    private function detectBab($text)
    {
        $hasil = [];

        preg_match_all(
            '/BAB\s+([0-9IVXLC]+)\s*(.*?)\n/iu',
            $text,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        if (empty($matches[0])) {
            return [];
        }

        $total = count($matches[0]);

        for ($i = 0; $i < $total; $i++) {

            $awal = $matches[0][$i][1];

            $akhir = ($i == $total - 1)
                ? strlen($text)
                : $matches[0][$i + 1][1];

            $isiBab = substr(
                $text,
                $awal,
                $akhir - $awal
            );

            $hasil[] = [

                'nomor' => trim($matches[1][$i][0]),

                'judul' => trim($matches[2][$i][0]),

                'isi' => $isiBab,

                'pertemuan' =>
                    $this->detectPertemuan(
                        $isiBab
                    ),

            ];
        }

        return $hasil;
    }

    private function detectPertemuan($isiBab)
    {
        $hasil = [];

        preg_match_all(
            '/Pertemuan\s+([0-9]+)/iu',
            $isiBab,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        if (empty($matches[0])) {
            return [];
        }

        $jumlah = count($matches[0]);

        for ($i = 0; $i < $jumlah; $i++) {

            $awal = $matches[0][$i][1];

            $akhir = ($i == $jumlah - 1)
                ? strlen($isiBab)
                : $matches[0][$i + 1][1];

            $isi = substr(
                $isiBab,
                $awal,
                $akhir - $awal
            );

            $hasil[] = [

                'nomor' =>
                    $matches[1][$i][0],

                'isi' =>
                    trim($isi),

            ];
        }

        return $hasil;
    }

    public function save()
    {
        $data = session('struktur_modul_ajar');

        if (!$data || empty($data['struktur'])) {

            return redirect()
                ->route('modul-ajar.upload')
                ->with(
                    'error',
                    'Data hasil analisis tidak ditemukan.'
                );
        }

        $struktur = $data['struktur'];

        $service = new ModulAjarSaveService();

        $service->simpan($struktur);

        session()->forget('struktur_modul_ajar');

        return redirect()
            ->route('modul-ajar.index')
            ->with(
                'success',
                'Modul ajar berhasil disimpan.'
            );
    }

    

    
}
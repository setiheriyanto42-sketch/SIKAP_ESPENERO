<?php

namespace App\Http\Controllers;

use App\Models\PenilaianAkademik;
use App\Models\PenilaianAkademikDetail;
use App\Models\PerencanaanPertemuan;
use App\Models\SesiMengajar;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianAkademikController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENILAIAN AKADEMIK
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $penilaians = PenilaianAkademik::with([
                'sesiMengajar.jadwalMengajar.guruMengajar.guru',
                'sesiMengajar.jadwalMengajar.guruMengajar.kelas',
                'sesiMengajar.jadwalMengajar.guruMengajar.mataPelajaran',
                'pertemuan.bab',
            ])
            ->withCount('details')
            ->latest()
            ->get();

        return view(
            'penilaian_akademik.index',
            compact('penilaians')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM BUAT PENILAIAN AKADEMIK
    |--------------------------------------------------------------------------
    */
    public function create(
        SesiMengajar $sesiMengajar,
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | AMBIL RELASI SESI MENGAJAR
        |--------------------------------------------------------------------------
        */
        $sesiMengajar->load([
            'jadwalMengajar.guruMengajar.guru',
            'jadwalMengajar.guruMengajar.kelas',
            'jadwalMengajar.guruMengajar.mataPelajaran',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GURU MENGAJAR
        |--------------------------------------------------------------------------
        */
        $guruMengajar =
            $sesiMengajar->jadwalMengajar?->guruMengajar;

        if (!$guruMengajar) {
            return back()->with(
                'error',
                'Data guru mengajar tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KELAS
        |--------------------------------------------------------------------------
        */
        $kelas = $guruMengajar->kelas;

        if (!$kelas) {
            return back()->with(
                'error',
                'Data kelas tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA SESUAI TINGKAT DAN ROMBEL
        |--------------------------------------------------------------------------
        |
        | tabel kelas:
        | tingkat = 7
        | rombel  = B
        |
        | tabel siswas:
        | kelas   = 7
        | rombel  = B
        |
        */
        $siswas = Siswa::where(
                'kelas',
                $kelas->tingkat
            )
            ->where(
                'rombel',
                $kelas->rombel
            )
            ->where('aktif', 1)
            ->orderBy('nama')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PERTEMUAN
        |--------------------------------------------------------------------------
        */
        $pertemuan = null;

        if ($request->filled('pertemuan')) {
            $pertemuan = PerencanaanPertemuan::with('bab')
                ->find($request->pertemuan);
        }

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN FORM
        |--------------------------------------------------------------------------
        */
        return view(
            'penilaian_akademik.create',
            compact(
                'sesiMengajar',
                'guruMengajar',
                'kelas',
                'siswas',
                'pertemuan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENILAIAN AKADEMIK
    |--------------------------------------------------------------------------
    */
    public function store(
        Request $request,
        SesiMengajar $sesiMengajar
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'perencanaan_pertemuan_id' =>
                'nullable|exists:perencanaan_pertemuans,id',

            'jenis' =>
                'required|in:Tugas,UH,Praktik,Proyek',

            'judul' =>
                'required|string|max:255',

            'tanggal' =>
                'nullable|date',

            'keterangan' =>
                'nullable|string',

            'nilai' =>
                'required|array',

            'nilai.*' =>
                'nullable|numeric|min:0|max:100',

            'catatan' =>
                'nullable|array',

            'catatan.*' =>
                'nullable|string|max:1000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $validated,
            $request,
            $sesiMengajar
        ) {

            /*
            |--------------------------------------------------------------------------
            | HEADER PENILAIAN
            |--------------------------------------------------------------------------
            */
            $penilaian = PenilaianAkademik::create([

                'sesi_mengajar_id' =>
                    $sesiMengajar->id,

                'perencanaan_pertemuan_id' =>
                    $validated['perencanaan_pertemuan_id']
                    ?? null,

                'jenis' =>
                    $validated['jenis'],

                'judul' =>
                    $validated['judul'],

                'tanggal' =>
                    $validated['tanggal']
                    ?? now()->toDateString(),

                'keterangan' =>
                    $validated['keterangan']
                    ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | DETAIL NILAI SISWA
            |--------------------------------------------------------------------------
            */
            foreach ($validated['nilai'] as $siswaId => $nilai) {

                /*
                | Nilai kosong boleh dilewati.
                */
                if ($nilai === null || $nilai === '') {
                    continue;
                }

                PenilaianAkademikDetail::create([

                    'penilaian_akademik_id' =>
                        $penilaian->id,

                    'siswa_id' =>
                        $siswaId,

                    'nilai' =>
                        $nilai,

                    'catatan' =>
                        $request->input(
                            'catatan.' . $siswaId
                        ),
                ]);
            }
        });

        return redirect()
            ->route('penilaian-akademik.index')
            ->with(
                'success',
                'Nilai akademik berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LIHAT DETAIL PENILAIAN
    |--------------------------------------------------------------------------
    */
    public function show(
        PenilaianAkademik $penilaianAkademik
    ) {
        $penilaianAkademik->load([

            'sesiMengajar.jadwalMengajar.guruMengajar.guru',

            'sesiMengajar.jadwalMengajar.guruMengajar.kelas',

            'sesiMengajar.jadwalMengajar.guruMengajar.mataPelajaran',

            'pertemuan.bab',

            'details.siswa',
        ]);

        return view(
            'penilaian_akademik.show',
            [
                'penilaian' => $penilaianAkademik
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT PENILAIAN
    |--------------------------------------------------------------------------
    */
    public function edit(
        PenilaianAkademik $penilaianAkademik
    ) {
        /*
        |--------------------------------------------------------------------------
        | LOAD DATA PENILAIAN
        |--------------------------------------------------------------------------
        */
        $penilaianAkademik->load([

            'sesiMengajar.jadwalMengajar.guruMengajar.guru',

            'sesiMengajar.jadwalMengajar.guruMengajar.kelas',

            'sesiMengajar.jadwalMengajar.guruMengajar.mataPelajaran',

            'pertemuan.bab',

            'details.siswa',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL GURU MENGAJAR
        |--------------------------------------------------------------------------
        */
        $guruMengajar = $penilaianAkademik
            ->sesiMengajar
            ?->jadwalMengajar
            ?->guruMengajar;

        /*
        |--------------------------------------------------------------------------
        | AMBIL KELAS
        |--------------------------------------------------------------------------
        */
        $kelas = $guruMengajar?->kelas;

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA SISWA KELAS
        |--------------------------------------------------------------------------
        */
        $siswas = collect();

        if ($kelas) {

            $siswas = Siswa::where(
                    'kelas',
                    $kelas->tingkat
                )
                ->where(
                    'rombel',
                    $kelas->rombel
                )
                ->where('aktif', 1)
                ->orderBy('nama')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL NILAI LAMA
        |--------------------------------------------------------------------------
        |
        | Dibuat berdasarkan siswa_id agar Blade mudah mengambil:
        |
        | $details[$siswa->id]
        |
        */
        $details = $penilaianAkademik
            ->details
            ->keyBy('siswa_id');

        return view(
            'penilaian_akademik.edit',
            [
                'penilaian' =>
                    $penilaianAkademik,

                'siswas' =>
                    $siswas,

                'details' =>
                    $details,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PENILAIAN AKADEMIK
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        PenilaianAkademik $penilaianAkademik
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'jenis' =>
                'required|in:Tugas,UH,Praktik,Proyek',

            'judul' =>
                'required|string|max:255',

            'tanggal' =>
                'required|date',

            'keterangan' =>
                'nullable|string',

            'nilai' =>
                'required|array',

            'nilai.*' =>
                'nullable|numeric|min:0|max:100',

            'catatan' =>
                'nullable|array',

            'catatan.*' =>
                'nullable|string|max:1000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $validated,
            $request,
            $penilaianAkademik
        ) {

            /*
            |--------------------------------------------------------------------------
            | UPDATE HEADER PENILAIAN
            |--------------------------------------------------------------------------
            */
            $penilaianAkademik->update([

                'jenis' =>
                    $validated['jenis'],

                'judul' =>
                    $validated['judul'],

                'tanggal' =>
                    $validated['tanggal'],

                'keterangan' =>
                    $validated['keterangan']
                    ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE DETAIL NILAI
            |--------------------------------------------------------------------------
            */
            foreach ($validated['nilai'] as $siswaId => $nilai) {

                /*
                |--------------------------------------------------------------------------
                | JIKA NILAI DIKOSONGKAN
                |--------------------------------------------------------------------------
                |
                | Detail nilai siswa tersebut dihapus.
                |
                */
                if ($nilai === null || $nilai === '') {

                    PenilaianAkademikDetail::where(
                        'penilaian_akademik_id',
                        $penilaianAkademik->id
                    )
                    ->where(
                        'siswa_id',
                        $siswaId
                    )
                    ->delete();

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | UPDATE NILAI LAMA / BUAT JIKA BELUM ADA
                |--------------------------------------------------------------------------
                */
                PenilaianAkademikDetail::updateOrCreate(

                    [
                        'penilaian_akademik_id' =>
                            $penilaianAkademik->id,

                        'siswa_id' =>
                            $siswaId,
                    ],

                    [
                        'nilai' =>
                            $nilai,

                        'catatan' =>
                            $request->input(
                                'catatan.' . $siswaId
                            ),
                    ]
                );
            }
        });

        return redirect()
            ->route(
                'penilaian-akademik.show',
                $penilaianAkademik
            )
            ->with(
                'success',
                'Nilai siswa berhasil diperbarui.'
            );
    }
}
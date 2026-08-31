<?php

namespace App\Http\Controllers;

use App\Models\TemplateJadwal;
use App\Models\TemplateHari;
use App\Models\TemplateJamPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TemplateJadwalController extends Controller
{
    /**
     * Daftar hari sekolah.
     */
    private function daftarHari(): array
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
    }

    /**
     * Urutan hari MySQL.
     */
    private function urutanHari(): string
    {
        return "FIELD(
            hari,
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        )";
    }

    /**
     * INDEX
     */
    public function index()
    {
        $templates = TemplateJadwal::with('templateHaris')
            ->orderBy('nama')
            ->get();

        return view(
            'template_jadwal.index',
            compact('templates')
        );
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('template_jadwal.create');
    }

    /**
     * SIMPAN TEMPLATE BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',

            'durasi_jp' => [
                'required',
                'integer',
                'min:1',
            ],

            'jumlah_jp' => [
                'required',
                'integer',
                'min:1',
            ],

            'istirahat_setelah' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'durasi_istirahat' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'ishoma_setelah' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'durasi_ishoma' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'hari' => [
                'required',
                'array',
            ],

            'hari.*.jam_mulai' => [
                'required',
                'date_format:H:i',
            ],
        ]);

        DB::transaction(function () use ($request) {

            /*
             * =====================================================
             * 1. SIMPAN TEMPLATE JADWAL
             * =====================================================
             */

            $template = TemplateJadwal::create([
                'nama' => $request->nama,

                'durasi_jp' => $request->durasi_jp,

                /*
                 * Dipertahankan untuk kompatibilitas
                 * dengan struktur lama.
                 */
                'jam_masuk' => $request->jam_masuk ?? '07:00',

                'jumlah_jp' => $request->jumlah_jp,

                'istirahat_setelah' =>
                    $request->istirahat_setelah,

                'durasi_istirahat' =>
                    $request->durasi_istirahat ?? 20,

                'ishoma_setelah' =>
                    $request->ishoma_setelah,

                'durasi_ishoma' =>
                    $request->durasi_ishoma ?? 40,

                'aktif' =>
                    $request->boolean('aktif'),

                'keterangan' =>
                    $request->keterangan,
            ]);

            /*
             * =====================================================
             * 2. SIMPAN JAM MULAI SETIAP HARI
             * =====================================================
             *
             * Data berasal dari:
             *
             * hari[Senin][jam_mulai]
             * hari[Selasa][jam_mulai]
             * dst.
             */

            foreach ($this->daftarHari() as $namaHari) {

                $jamMulai =
                    $request->input(
                        "hari.{$namaHari}.jam_mulai"
                    );

                if (!$jamMulai) {
                    continue;
                }

                TemplateHari::create([
                    'template_jadwal_id' =>
                        $template->id,

                    'hari' =>
                        $namaHari,

                    'jam_mulai' =>
                        $jamMulai,

                    'aktif' => true,
                ]);
            }
        });

        return redirect()
            ->route('template-jadwal.index')
            ->with(
                'success',
                'Template jadwal berhasil disimpan.'
            );
    }

    /**
     * FORM EDIT
     */
    public function edit(
        TemplateJadwal $templateJadwal
    ) {
        $templateJadwal->load('templateHaris');

        return view(
            'template_jadwal.edit',
            compact('templateJadwal')
        );
    }

    /**
     * UPDATE TEMPLATE
     */
    public function update(
        Request $request,
        TemplateJadwal $templateJadwal
    ) {
        $request->validate([
            'nama' =>
                'required|string|max:255',

            'durasi_jp' =>
                'required|integer|min:1',

            'jumlah_jp' =>
                'required|integer|min:1',

            'istirahat_setelah' =>
                'nullable|integer|min:1',

            'durasi_istirahat' =>
                'nullable|integer|min:1',

            'ishoma_setelah' =>
                'nullable|integer|min:1',

            'durasi_ishoma' =>
                'nullable|integer|min:1',

            'hari' =>
                'required|array',

            'hari.*.jam_mulai' =>
                'required|date_format:H:i',
        ]);

        DB::transaction(function () use (
            $request,
            $templateJadwal
        ) {

            /*
             * =====================================================
             * 1. UPDATE TEMPLATE UTAMA
             * =====================================================
             */

            $templateJadwal->update([
                'nama' =>
                    $request->nama,

                'durasi_jp' =>
                    $request->durasi_jp,

                'jumlah_jp' =>
                    $request->jumlah_jp,

                'istirahat_setelah' =>
                    $request->istirahat_setelah,

                'durasi_istirahat' =>
                    $request->durasi_istirahat,

                'ishoma_setelah' =>
                    $request->ishoma_setelah,

                'durasi_ishoma' =>
                    $request->durasi_ishoma,

                'aktif' =>
                    $request->boolean('aktif'),
            ]);

            /*
             * =====================================================
             * 2. UPDATE JAM SETIAP HARI
             * =====================================================
             */

            foreach ($this->daftarHari() as $namaHari) {

                $jamMulai =
                    $request->input(
                        "hari.{$namaHari}.jam_mulai"
                    );

                if (!$jamMulai) {
                    continue;
                }

                TemplateHari::updateOrCreate(
                    [
                        'template_jadwal_id' =>
                            $templateJadwal->id,

                        'hari' =>
                            $namaHari,
                    ],
                    [
                        'jam_mulai' =>
                            $jamMulai,

                        'aktif' => true,
                    ]
                );
            }

            /*
             * =====================================================
             * 3. HAPUS HASIL GENERATE LAMA
             * =====================================================
             *
             * Karena konfigurasi waktu berubah,
             * hasil generate lama harus dibuat ulang.
             */

            TemplateJamPelajaran::where(
                'template_jadwal_id',
                $templateJadwal->id
            )->delete();
        });

        return redirect()
            ->route('template-jadwal.index')
            ->with(
                'success',
                'Template jadwal berhasil diperbarui.'
            );
    }

    /**
     * HAPUS TEMPLATE
     */
    public function destroy(
        TemplateJadwal $templateJadwal
    ) {
        $templateJadwal->delete();

        return back()->with(
            'success',
            'Template jadwal berhasil dihapus.'
        );
    }

    /**
     * ============================================================
     * GENERATE JADWAL
     * ============================================================
     *
     * Satu mesin generate untuk seluruh hari aktif.
     */
    public function generate(
        TemplateJadwal $templateJadwal
    ) {
        DB::transaction(function () use ($templateJadwal) {

            /*
             * Hapus hasil generate sebelumnya.
             */
            TemplateJamPelajaran::where(
                'template_jadwal_id',
                $templateJadwal->id
            )->delete();

            /*
             * Ambil semua hari aktif.
             */
            $templateHari = TemplateHari::where(
                'template_jadwal_id',
                $templateJadwal->id
            )
            ->where('aktif', true)
            ->orderByRaw($this->urutanHari())
            ->get();

            /*
             * Generate setiap hari.
             */
            foreach ($templateHari as $hari) {

                $this->generateUntukHari(
                    $templateJadwal,
                    $hari
                );
            }
        });

        return back()->with(
            'success',
            'Template jadwal berhasil digenerate untuk seluruh hari aktif.'
        );
    }

    /**
     * GENERATE SATU HARI
     *
     * Dipertahankan untuk kompatibilitas route lama.
     */
    public function generateHari(
        TemplateHari $templateHari
    ) {
        $templateJadwal =
            $templateHari->templateJadwal;

        DB::transaction(function () use (
            $templateHari,
            $templateJadwal
        ) {

            /*
             * Hapus hasil hari tersebut.
             */
            TemplateJamPelajaran::where(
                'template_hari_id',
                $templateHari->id
            )->delete();

            $this->generateUntukHari(
                $templateJadwal,
                $templateHari
            );
        });

        return back()->with(
            'success',
            "Jadwal {$templateHari->hari} berhasil digenerate."
        );
    }

    /**
     * MESIN INTERNAL GENERATE SATU HARI
     */
    private function generateUntukHari(
        TemplateJadwal $templateJadwal,
        TemplateHari $templateHari
    ): void {

        /*
         * Pastikan jam tersedia.
         */
        if (!$templateHari->jam_mulai) {
            return;
        }

        /*
        * ==========================================================
        * ATURAN WAKTU KHUSUS PER HARI
        * ==========================================================
        *
        * Jika TemplateHari memiliki nilai khusus,
        * gunakan nilai tersebut.
        *
        * Jika kosong/null, gunakan aturan dari TemplateJadwal.
        */

        $istirahatSetelah =
            $templateHari->istirahat_setelah
            ?? $templateJadwal->istirahat_setelah;

        $durasiIstirahat =
            $templateHari->durasi_istirahat
            ?? $templateJadwal->durasi_istirahat;

        $ishomaSetelah =
            $templateHari->ishoma_setelah
            ?? $templateJadwal->ishoma_setelah;

        $durasiIshoma =
            $templateHari->durasi_ishoma
            ?? $templateJadwal->durasi_ishoma;


        /*
        * ==========================================================
        * ATURAN KHUSUS HARI RABU
        * ==========================================================
        *
        * Rabu:
        * - ISHOMA setelah JP 6
        * - Durasi ISHOMA 25 menit
        *
        * Setelah ISHOMA:
        * JP 7 dan JP 8 tetap berjalan normal 40 menit.
        */

        if ($templateHari->hari === 'Rabu') {

            $ishomaSetelah = 6;

            $durasiIshoma = 25;
        }

        /*
         * JP 1 dimulai dari jam milik hari tersebut.
         *
         * Contoh:
         * Senin = 07:00
         * Rabu  = 07:30
         */
        $jam = Carbon::createFromFormat(
            'H:i',
            substr(
                $templateHari->jam_mulai,
                0,
                5
            )
        );

        $urutan = 1;

        /*
         * =====================================================
         * LOOP JP
         * =====================================================
         */

        for (
            $i = 1;
            $i <= $templateJadwal->jumlah_jp;
            $i++
        ) {

            /*
             * -----------------------------------------------
             * JAM MULAI JP
             * -----------------------------------------------
             */

            


            /*
            * -----------------------------------------------
            * JAM MULAI JP
            * -----------------------------------------------
            */

            $jamMulai = $jam->copy();

            $jamMulai = $jam->copy();

            /*
             * -----------------------------------------------
             * JAM SELESAI JP
             * -----------------------------------------------
             */

            $jamSelesai = $jam->copy()
                ->addMinutes(
                    $templateJadwal->durasi_jp
                );

            /*
             * -----------------------------------------------
             * SIMPAN JP
             * -----------------------------------------------
             */

            TemplateJamPelajaran::create([

                'template_jadwal_id' =>
                    $templateJadwal->id,

                'template_hari_id' =>
                    $templateHari->id,

                'hari' =>
                    $templateHari->hari,

                'nama_template' =>
                    $templateJadwal->nama,

                /*
                 * JP = nomor JP.
                 */
                'jp' => $i,

                'nomor_jp' => $i,

                'jam_ke' => $i,

                'jam_mulai' =>
                    $jamMulai->format('H:i:s'),

                'jam_selesai' =>
                    $jamSelesai->format('H:i:s'),

                'jenis' =>
                    'belajar',

                'aktif' => true,

                'urutan' =>
                    $urutan++,
            ]);

            /*
             * Geser ke waktu berikutnya.
             */
            $jam->addMinutes(
                $templateJadwal->durasi_jp
            );

            /*
             * =================================================
             * ISTIRAHAT
             * =================================================
             */

            if (
                $istirahatSetelah
                &&
                $i == $istirahatSetelah
            ) {

                $istirahatMulai =
                    $jam->copy();

                $istirahatSelesai =
                    $jam->copy()->addMinutes(
                        $templateJadwal
                            ->durasi_istirahat
                    );

                TemplateJamPelajaran::create([

                    'template_jadwal_id' =>
                        $templateJadwal->id,

                    'template_hari_id' =>
                        $templateHari->id,

                    'hari' =>
                        $templateHari->hari,

                    'nama_template' =>
                        $templateJadwal->nama,

                    'jp' => null,

                    'nomor_jp' => null,

                    'jam_ke' => null,

                    'jam_mulai' =>
                        $istirahatMulai
                            ->format('H:i:s'),

                    'jam_selesai' =>
                        $istirahatSelesai
                            ->format('H:i:s'),

                    'jenis' =>
                        'istirahat_1',

                    'aktif' => true,

                    'urutan' =>
                        $urutan++,
                ]);

                $jam->addMinutes(
                    $templateJadwal
                        ->durasi_istirahat
                );
            }

            /*
             * =================================================
             * ISHOMA
             * =================================================
             */

            if (
                $ishomaSetelah
                &&
                $i == $ishomaSetelah
            ) {

                $ishomaMulai =
                    $jam->copy();

                $ishomaSelesai =
                $jam->copy()->addMinutes(
                    $durasiIshoma
                );

                TemplateJamPelajaran::create([

                    'template_jadwal_id' =>
                        $templateJadwal->id,

                    'template_hari_id' =>
                        $templateHari->id,

                    'hari' =>
                        $templateHari->hari,

                    'nama_template' =>
                        $templateJadwal->nama,

                    'jp' => null,

                    'nomor_jp' => null,

                    'jam_ke' => null,

                    'jam_mulai' =>
                        $ishomaMulai
                            ->format('H:i:s'),

                    'jam_selesai' =>
                        $ishomaSelesai
                            ->format('H:i:s'),

                    'jenis' =>
                        'ishoma',

                    'aktif' => true,

                    'urutan' =>
                        $urutan++,
                ]);

                $jam->addMinutes(
                    $durasiIshoma
                );
            }
        }
    }

    /**
     * DETAIL TEMPLATE
     */
    public function show(
        TemplateJadwal $templateJadwal
    ) {
        $templateJadwal->load([
            'jamPelajaran' => function ($query) {
                $query->orderBy('hari')
                    ->orderBy('urutan');
            },
            'jamPelajaran.templateHari',
            'templateHaris',
        ]);

        return view(
            'template_jadwal.show',
            compact('templateJadwal')
        );
    }

    /**
     * SETTING HARI
     */
    public function hari(
        TemplateJadwal $templateJadwal
    ) {
        $hari = $this->daftarHari();

        $templateJadwal->load(
            'templateHaris'
        );

        return view(
            'template_jadwal.hari',
            compact(
                'templateJadwal',
                'hari'
            )
        );
    }

    /**
     * UPDATE JAM HARI
     */
    public function updateHari(
        Request $request,
        TemplateJadwal $templateJadwal
    ) {
        $request->validate([
            'hari' =>
                'required|array',

            'jam_mulai' =>
                'required|array',

            'jam_mulai.*' =>
                'required|date_format:H:i',
        ]);

        DB::transaction(function () use (
            $request,
            $templateJadwal
        ) {

            foreach (
                $request->hari
                as $index => $namaHari
            ) {

                TemplateHari::updateOrCreate(
                    [
                        'template_jadwal_id' =>
                            $templateJadwal->id,

                        'hari' =>
                            $namaHari,
                    ],
                    [
                        'jam_mulai' =>
                            $request
                                ->jam_mulai[$index],

                        'aktif' =>
                            isset(
                                $request
                                    ->aktif[$index]
                            ),
                    ]
                );
            }

            /*
             * Jam berubah → hasil generate lama
             * harus dihapus.
             */
            TemplateJamPelajaran::where(
                'template_jadwal_id',
                $templateJadwal->id
            )->delete();
        });

        return redirect()
            ->route(
                'template-jadwal.index'
            )
            ->with(
                'success',
                'Pengaturan jam mulai setiap hari berhasil disimpan. Silakan Generate kembali.'
            );
    }
}


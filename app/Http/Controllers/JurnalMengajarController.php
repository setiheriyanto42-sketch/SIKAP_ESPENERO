<?php

namespace App\Http\Controllers;

use App\Models\JurnalMengajar;
use App\Models\SesiMengajar;
use App\Models\Kehadiran;
use App\Models\PerencanaanPembelajaran;
use App\Models\PerencanaanPertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalMengajarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR JURNAL
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $jurnals = JurnalMengajar::with([
            'sesiMengajar.jadwalMengajar.guruMengajar.guru',
            'sesiMengajar.jadwalMengajar.guruMengajar.kelas',
            'sesiMengajar.jadwalMengajar.guruMengajar.mataPelajaran',
            'perencanaanPertemuan.bab.modul',
        ])
        ->latest()
        ->paginate(20);

        return view(
            'jurnal_mengajar.index',
            compact('jurnals')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM JURNAL
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $request->validate([
            'sesi' => 'required|exists:sesi_mengajars,id',
        ]);

        $sesi = SesiMengajar::with([
            'jadwalMengajar.guruMengajar.guru',
            'jadwalMengajar.guruMengajar.kelas',
            'jadwalMengajar.guruMengajar.mataPelajaran',
        ])->findOrFail($request->sesi);

        $guruMengajar = $sesi->jadwalMengajar->guruMengajar;
        $kelas = $guruMengajar->kelas;

        /*
        |--------------------------------------------------------------------------
        | REKAP KEHADIRAN
        |--------------------------------------------------------------------------
        */
        $hadir = Kehadiran::where(
            'sesi_mengajar_id',
            $sesi->id
        )
        ->where('status', 'Hadir')
        ->count();

        $tidakHadir = Kehadiran::where(
            'sesi_mengajar_id',
            $sesi->id
        )
        ->where('status', '!=', 'Hadir')
        ->count();

        /*
        |--------------------------------------------------------------------------
        | CARI MODUL YANG SESUAI
        |--------------------------------------------------------------------------
        |
        | Guru + Mapel + Tingkat kelas.
        |
        */
        $moduls = PerencanaanPembelajaran::with([
            'babs' => function ($query) {
                $query->where('aktif', true)
                    ->orderBy('urutan')
                    ->with([
                        'pertemuans' => function ($query) {
                            $query->orderBy('pertemuan_ke');
                        }
                    ]);
            }
        ])
        ->where('guru_id', $guruMengajar->guru_id)
        ->where(
            'mata_pelajaran_id',
            $guruMengajar->mata_pelajaran_id
        )
        ->where('tingkat', $kelas->tingkat)
        ->where('aktif', true)
        ->get();

        return view(
            'jurnal_mengajar.create',
            compact(
                'sesi',
                'hadir',
                'tidakHadir',
                'moduls'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN JURNAL
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'sesi_mengajar_id' =>
                'required|exists:sesi_mengajars,id',

            'perencanaan_pertemuan_id' =>
                'required|exists:perencanaan_pertemuans,id',

            'materi_tercapai' =>
                'required|string',

            'catatan' =>
                'nullable|string',

            'refleksi' =>
                'nullable|string',

            'jumlah_hadir' =>
                'nullable|integer|min:0',

            'jumlah_tidak_hadir' =>
                'nullable|integer|min:0',
        ]);

        $sesi = SesiMengajar::findOrFail(
            $validated['sesi_mengajar_id']
        );

        $pertemuan = PerencanaanPertemuan::with('bab')
            ->findOrFail(
                $validated['perencanaan_pertemuan_id']
            );

        DB::transaction(function () use (
            $validated,
            $sesi,
            $pertemuan
        ) {

            JurnalMengajar::updateOrCreate(

                [
                    'sesi_mengajar_id' => $sesi->id,
                ],

                [
                    'perencanaan_pertemuan_id' =>
                        $pertemuan->id,

                    /*
                    | Materi rencana dari Modul Ajar.
                    */
                    'materi' =>
                        $pertemuan->materi,

                    /*
                    | Tujuan otomatis dari Modul Ajar.
                    */
                    'tujuan' =>
                        $pertemuan->tujuan,

                    /*
                    | Yang benar-benar dicapai hari ini.
                    */
                    'materi_tercapai' =>
                        $validated['materi_tercapai'],

                    'catatan' =>
                        $validated['catatan'] ?? null,

                    'refleksi' =>
                        $validated['refleksi'] ?? null,

                    'jumlah_hadir' =>
                        $validated['jumlah_hadir'] ?? 0,

                    'jumlah_tidak_hadir' =>
                        $validated['jumlah_tidak_hadir'] ?? 0,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | TANDAI PERTEMUAN SUDAH DIAJARKAN
            |--------------------------------------------------------------------------
            */
            $pertemuan->update([

                'sudah_diajarkan' => true,

                'tanggal' => $sesi->tanggal,

            ]);

            /*
            |--------------------------------------------------------------------------
            | SELESAIKAN SESI
            |--------------------------------------------------------------------------
            */
            $sesi->update([

                'status' => 'Selesai',

                'jam_selesai' => now(),

            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | TIDAK LANGSUNG KE PENILAIAN
        |--------------------------------------------------------------------------
        |
        | Penilaian bukan kewajiban setiap pertemuan.
        |
        */
        /*
        |--------------------------------------------------------------------------
        | ARAHKAN KE PENILAIAN JIKA PERTEMUAN MEMILIKI PENILAIAN
        |--------------------------------------------------------------------------
        */

        if ($pertemuan->ada_penilaian) {

            return redirect()
                ->route('penilaian.create', [
                    'sesiMengajar' => $sesi->id
                ])
                ->with(
                    'success',
                    'Jurnal berhasil disimpan. Silakan lanjutkan penilaian siswa.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA PENILAIAN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('jurnal-mengajar.index')
            ->with(
                'success',
                'Jurnal pembelajaran berhasil disimpan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT JURNAL
    |--------------------------------------------------------------------------
    */
    public function edit(JurnalMengajar $jurnalMengajar)
    {
        $jurnalMengajar->load([
            'sesiMengajar.jadwalMengajar.guruMengajar.guru',
            'sesiMengajar.jadwalMengajar.guruMengajar.kelas',
            'sesiMengajar.jadwalMengajar.guruMengajar.mataPelajaran',
            'perencanaanPertemuan.bab.modul',
        ]);

        return view(
            'jurnal_mengajar.edit',
            [
                'jurnal' => $jurnalMengajar
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE JURNAL
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        JurnalMengajar $jurnalMengajar
    ) {
        $validated = $request->validate([

            'materi_tercapai' =>
                'required|string',

            'catatan' =>
                'nullable|string',

            'refleksi' =>
                'nullable|string',
        ]);

        $jurnalMengajar->update($validated);

        return redirect()
            ->route('jurnal-mengajar.index')
            ->with(
                'success',
                'Jurnal pembelajaran berhasil diperbarui.'
            );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\SesiMengajar;
use App\Models\Siswa;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class AbsensiMengajarController extends Controller
{
    public function index(JadwalMengajar $jadwalMengajar)
    {
        $sesi = SesiMengajar::where(
            'jadwal_mengajar_id',
            $jadwalMengajar->id
        )
        ->whereDate('tanggal', today())
        ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Kalau sesi sudah selesai
        |--------------------------------------------------------------------------
        */

        if ($sesi->status == 'Selesai') {

            return redirect()
                ->route('dashboard')
                ->with('warning', 'Pembelajaran hari ini sudah selesai.');

        }

        $kelas = $jadwalMengajar->guruMengajar->kelas;

        $siswas = Siswa::where('kelas', $kelas->tingkat)
            ->where('rombel', $kelas->rombel)
            ->orderBy('nama')
            ->get();

        return view('mengajar.index', compact(
            'jadwalMengajar',
            'kelas',
            'siswas',
            'sesi'
        ));
    }

    public function store(Request $request, JadwalMengajar $jadwalMengajar)
    {
        $request->validate([

            'sesi_id' => 'required|exists:sesi_mengajars,id',

            'siswa_id' => 'required|array',

            'status' => 'required|array',

        ]);

        $sesi = SesiMengajar::findOrFail($request->sesi_id);

        /*
        |--------------------------------------------------------------------------
        | Cegah simpan jika sesi selesai
        |--------------------------------------------------------------------------
        */

        if ($sesi->status == 'Selesai') {

            return redirect()
                ->route('dashboard')
                ->with('warning', 'Sesi sudah selesai.');

        }

        $guruMengajar = $jadwalMengajar->guruMengajar;

        foreach ($request->siswa_id as $i => $siswaId) {

            Kehadiran::updateOrCreate(

                [

                    'sesi_mengajar_id' => $request->sesi_id,

                    'siswa_id' => $siswaId,

                ],

                [

                    'tanggal' => today(),

                    'guru_id' => $guruMengajar->guru_id,

                    'kelas_id' => $guruMengajar->kelas_id,

                    'mapel_id' => $guruMengajar->mata_pelajaran_id,

                    'mata_pelajaran' => $guruMengajar->mataPelajaran->nama_mapel,

                    'jenis_absensi' => 'KBM',

                    'kegiatan' => 'Pembelajaran',

                    'status' => $request->status[$i],

                ]

            );

        }

        return redirect()->route(

            'jurnal-mengajar.create',

            [

                'sesi' => $request->sesi_id

            ]

        );
    }
}

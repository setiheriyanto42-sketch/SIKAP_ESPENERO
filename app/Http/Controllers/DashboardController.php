<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\JadwalMengajar;
use App\Models\GuruMengajar;
use App\Models\SesiMengajar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jadwalHariIni = collect();

        $data = [

            // Dashboard Admin
            'jumlahGuru' => Guru::count(),
            'jumlahSiswa' => Siswa::count(),
            'jumlahKelas' => Kelas::count(),
            'jumlahMapel' => MataPelajaran::count(),

            // Dashboard Guru
            'jamMengajar' => 0,
            'kelasDiampu' => 0,
            'jumlahSiswaDiampu' => 0,

            // Tahun aktif
            'tahunAktif' => TahunAjaran::where('aktif', true)->first(),

            // Wali kelas
            'isWaliKelas' => false,
            'kelasPerwalian' => null,

        ];

        if ($user->guru) {

            /*
            |--------------------------------------------------------------------------
            | WALI KELAS
            |--------------------------------------------------------------------------
            */

            $kelas = Kelas::where('guru_id', $user->guru->id)->first();

            if ($kelas) {

                $data['isWaliKelas'] = true;
                $data['kelasPerwalian'] = $kelas;

            }

            /*
            |--------------------------------------------------------------------------
            | HARI INI
            |--------------------------------------------------------------------------
            */

            Carbon::setLocale('id');

            $hari = ucfirst(Carbon::now()->translatedFormat('l'));

            /*
            |--------------------------------------------------------------------------
            | JADWAL HARI INI
            |--------------------------------------------------------------------------
            */

            $jadwalHariIni = JadwalMengajar::with([
                'guruMengajar.guru',
                'guruMengajar.kelas',
                'guruMengajar.mataPelajaran'
            ])
            ->whereHas('guruMengajar', function ($q) use ($user) {

                $q->where('guru_id', $user->guru_id);

            })
            ->where('hari', $hari)
            ->where('aktif', true)
            ->orderBy('jam_mulai')
            ->get();

            /*
            |--------------------------------------------------------------------------
            | STATUS SETIAP JADWAL
            |--------------------------------------------------------------------------
            */

            foreach ($jadwalHariIni as $jadwal) {

                $sesi = SesiMengajar::where('jadwal_mengajar_id', $jadwal->id)
                    ->whereDate('tanggal', today())
                    ->first();

                if (!$sesi) {

                    $jadwal->status_sesi = 'Belum';

                } else {

                    $jadwal->status_sesi = $sesi->status;

                }

            }

            /*
            |--------------------------------------------------------------------------
            | PENUGASAN GURU
            |--------------------------------------------------------------------------
            */

            $mengajar = GuruMengajar::with('kelas')
                ->where('guru_id', $user->guru_id)
                ->where('aktif', 1)
                ->get();

            $data['jamMengajar'] = JadwalMengajar::whereHas('guruMengajar', function ($q) use ($user) {

                $q->where('guru_id', $user->guru_id);

            })->count();

            $kelasIds = $mengajar->pluck('kelas_id')->unique();

            $data['kelasDiampu'] = $kelasIds->count();

            $jumlah = 0;

            foreach ($mengajar as $item) {

                $jumlah += Siswa::where('kelas', $item->kelas->tingkat)
                    ->where('rombel', $item->kelas->rombel)
                    ->count();

            }

            $data['jumlahSiswaDiampu'] = $jumlah;

        }

        return view('dashboard', [

            'user' => $user,
            'data' => $data,
            'jadwalHariIni' => $jadwalHariIni,

        ]);
    }
}

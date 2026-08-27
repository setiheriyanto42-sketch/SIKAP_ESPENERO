<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\SesiMengajar;
use Illuminate\Support\Facades\Auth;

class SesiMengajarController extends Controller
{
    /**
     * Mulai sesi pembelajaran.
     */
    public function mulai(JadwalMengajar $jadwalMengajar)
    {
        $jadwalMengajar->load([
            'guruMengajar.guru',
            'guruMengajar.kelas',
            'guruMengajar.mataPelajaran',
        ]);

        $guruMengajar = $jadwalMengajar->guruMengajar;

        if (!$guruMengajar) {
            return redirect()
                ->route('jadwal-mengajar.index')
                ->with('error', 'Penugasan guru pada jadwal ini tidak ditemukan.');
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | HAK AKSES
        |--------------------------------------------------------------------------
        |
        | ADMIN:
        | Boleh membuka semua jadwal untuk pengelolaan dan pengujian.
        |
        | GURU:
        | Hanya boleh membuka jadwal miliknya sendiri.
        |
        */

        $isAdmin = $user->isAdmin();

        if (
            !$isAdmin &&
            (int) $user->guru_id !== (int) $guruMengajar->guru_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke jadwal mengajar ini.');
        }

        /*
        |--------------------------------------------------------------------------
        | CARI / BUAT SESI HARI INI
        |--------------------------------------------------------------------------
        */

        $sesi = SesiMengajar::firstOrCreate(
            [
                'jadwal_mengajar_id' => $jadwalMengajar->id,
                'tanggal' => today()->toDateString(),
            ],
            [
                'guru_mengajar_id' => $guruMengajar->id,
                'jam_mulai' => now(),
                'status' => 'Sedang',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | SESI SUDAH SELESAI
        |--------------------------------------------------------------------------
        */

        if ($sesi->status === 'Selesai') {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'Pembelajaran pada jadwal ini hari ini sudah selesai.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | AKTIFKAN SESI
        |--------------------------------------------------------------------------
        */

        if ($sesi->status === 'Belum') {
            $sesi->update([
                'status' => 'Sedang',
                'jam_mulai' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LANJUT KE HALAMAN MENGAJAR / ABSENSI
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'mengajar.index',
            $jadwalMengajar
        );
    }


    /**
     * Selesaikan sesi pembelajaran.
     */
    public function selesai(SesiMengajar $sesiMengajar)
    {
        $sesiMengajar->load('guruMengajar');

        $user = Auth::user();

        $isAdmin = $user->isAdmin();

        if (
            !$isAdmin &&
            (int) $user->guru_id !== (int) $sesiMengajar->guruMengajar?->guru_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke sesi mengajar ini.');
        }

        if ($sesiMengajar->status === 'Selesai') {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'Pembelajaran ini sudah selesai.'
                );
        }

        $sesiMengajar->update([
            'status' => 'Selesai',
            'jam_selesai' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Pembelajaran selesai.'
            );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\SesiMengajar;
use Illuminate\Support\Facades\Auth;

class SesiMengajarController extends Controller
{
    public function mulai(JadwalMengajar $jadwalMengajar)
    {
        $guruMengajar = $jadwalMengajar->guruMengajar;

        // Pastikan hanya guru pemilik jadwal
        if (Auth::user()->guru_id != $guruMengajar->guru_id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari atau buat sesi hari ini
        |--------------------------------------------------------------------------
        */

        $sesi = SesiMengajar::firstOrCreate(

            [
                'jadwal_mengajar_id' => $jadwalMengajar->id,
                'tanggal' => today(),
            ],

            [
                'guru_mengajar_id' => $guruMengajar->id,
                'jam_mulai' => now(),
                'status' => 'Sedang',
            ]

        );

        /*
        |--------------------------------------------------------------------------
        | Kalau sesi sudah selesai tidak boleh dibuka lagi
        |--------------------------------------------------------------------------
        */

        if ($sesi->status == 'Selesai') {

            return redirect()
                ->route('dashboard')
                ->with('warning', 'Pembelajaran hari ini sudah selesai.');

        }

        /*
        |--------------------------------------------------------------------------
        | Kalau status masih Belum
        |--------------------------------------------------------------------------
        */

        if ($sesi->status == 'Belum') {

            $sesi->update([

                'status' => 'Sedang',

                'jam_mulai' => now(),

            ]);

        }

        return redirect()->route('mengajar.index', $jadwalMengajar);
    }

    public function selesai(SesiMengajar $sesiMengajar)
    {
        if ($sesiMengajar->status == 'Selesai') {

            return redirect()->route('dashboard');

        }

        $sesiMengajar->update([

            'status' => 'Selesai',

            'jam_selesai' => now(),

        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Pembelajaran selesai.');
    }
}

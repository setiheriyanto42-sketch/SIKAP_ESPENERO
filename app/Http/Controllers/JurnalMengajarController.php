<?php

namespace App\Http\Controllers;

use App\Models\JurnalMengajar;
use App\Models\SesiMengajar;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalMengajarController extends Controller
{
    public function create(Request $request)
    {
        $sesi = SesiMengajar::with([
            'jadwalMengajar.guruMengajar.guru',
            'jadwalMengajar.guruMengajar.kelas',
            'jadwalMengajar.guruMengajar.mataPelajaran'
        ])->findOrFail($request->sesi);

        $hadir = Kehadiran::where('sesi_mengajar_id', $sesi->id)
            ->where('status', 'Hadir')
            ->count();

        $tidakHadir = Kehadiran::where('sesi_mengajar_id', $sesi->id)
            ->where('status', '!=', 'Hadir')
            ->count();

        return view('jurnal_mengajar.create', compact(
            'sesi',
            'hadir',
            'tidakHadir'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([

            'sesi_mengajar_id' => 'required|exists:sesi_mengajars,id',

            'materi' => 'required|string',

        ]);

        DB::transaction(function () use ($request) {

            JurnalMengajar::updateOrCreate(

                [
                    'sesi_mengajar_id' => $request->sesi_mengajar_id,
                ],

                [
                    'materi' => $request->materi,
                    'tujuan' => $request->tujuan,
                    'catatan' => $request->catatan,
                    'jumlah_hadir' => $request->jumlah_hadir,
                    'jumlah_tidak_hadir' => $request->jumlah_tidak_hadir,
                ]

            );

            $sesi = SesiMengajar::findOrFail($request->sesi_mengajar_id);

            $sesi->update([

                'status' => 'Selesai',

                'jam_selesai' => now(),

            ]);

        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Pembelajaran berhasil diselesaikan.');
    }
}

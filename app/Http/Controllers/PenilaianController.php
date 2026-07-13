<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\SesiMengajar;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function create(SesiMengajar $sesiMengajar)
    {
        $sesiMengajar->load([
            'jadwalMengajar.guruMengajar.guru',
            'jadwalMengajar.guruMengajar.kelas',
            'jadwalMengajar.guruMengajar.mataPelajaran',
            'kehadirans.siswa'
        ]);

        $kehadirans = $sesiMengajar
            ->kehadirans()
            ->with('siswa')
            ->orderBy('siswa_id')
            ->get();

        $penilaians = Penilaian::where(
            'sesi_mengajar_id',
            $sesiMengajar->id
        )->get()->keyBy('siswa_id');

        return view(
            'penilaian.create',
            compact(
                'sesiMengajar',
                'kehadirans',
                'penilaians'
            )
        );
    }

    public function store(Request $request, SesiMengajar $sesiMengajar)
    {
        $request->validate([
            'predikat' => 'required|array',
        ]);

        foreach ($request->predikat as $siswaId => $predikat) {

            Penilaian::updateOrCreate(

                [
                    'sesi_mengajar_id' => $sesiMengajar->id,
                    'siswa_id' => $siswaId,
                ],

                [
                    'predikat' => $predikat,
                    'catatan' => $request->catatan[$siswaId] ?? null,
                ]

            );

        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Penilaian sikap berhasil disimpan.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kehadiran;
use App\Models\MataPelajaran;

class KehadiranController extends Controller
{
    /**
     * Form Absensi Manual (Admin)
     */
    public function input(Request $request)
    {
        $kelas = Kelas::orderBy('tingkat')
            ->orderBy('rombel')
            ->get();

        $mapel = MataPelajaran::where('aktif', 1)
            ->orderBy('nama_mapel')
            ->get();

        $siswas = [];

        if ($request->filled('kelas_id')) {

            $kelasDipilih = Kelas::find($request->kelas_id);

            if ($kelasDipilih) {

                $siswas = Siswa::where('kelas', $kelasDipilih->tingkat)
                    ->where('rombel', $kelasDipilih->rombel)
                    ->orderBy('nama')
                    ->get();
            }
        }

        return view('kehadiran.input', compact(
            'kelas',
            'mapel',
            'siswas'
        ));
    }

    /**
     * Simpan Absensi Manual
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'siswa_id' => 'required|array',
            'status' => 'required|array',
        ]);

        $mapel = MataPelajaran::findOrFail($request->mapel_id);

        foreach ($request->siswa_id as $index => $siswaId) {

            Kehadiran::updateOrCreate(

                [
                    'tanggal' => $request->tanggal,
                    'siswa_id' => $siswaId,
                    'jenis_absensi' => 'Harian',
                ],

                [
                    'guru_id' => Auth::user()->guru_id ?? 3,

                    'kelas_id' => $request->kelas_id,

                    'mapel_id' => $mapel->id,

                    'mata_pelajaran' => $mapel->nama_mapel,

                    'kegiatan' => 'Absensi Manual',

                    'status' => $request->status[$index],

                    'keterangan' => null,
                ]

            );
        }

        return redirect()
            ->route('kehadiran.input', [
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id,
                'tanggal' => $request->tanggal,
            ])
            ->with('success', 'Absensi berhasil disimpan.');
    }
}

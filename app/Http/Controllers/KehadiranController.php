<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kehadiran;
use App\Models\MataPelajaran;
use App\Models\Guru;

class KehadiranController extends Controller
{
    /**
     * Form Input Kehadiran
     */
    public function input(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Master Kelas
        |--------------------------------------------------------------------------
        */

        $kelas = Kelas::orderBy('tingkat')
            ->orderBy('rombel')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Master Mata Pelajaran
        |--------------------------------------------------------------------------
        */

        $mapel = MataPelajaran::where('aktif', 1)
            ->orderBy('nama_mapel')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        $siswas = collect();

        $kehadiranTersimpan = collect();


        /*
        |--------------------------------------------------------------------------
        | Ambil Siswa Berdasarkan Kelas
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kelas_id')) {

            $kelasDipilih = Kelas::find(
                $request->kelas_id
            );

            if ($kelasDipilih) {

                $siswas = Siswa::where(
                        'kelas',
                        $kelasDipilih->tingkat
                    )
                    ->where(
                        'rombel',
                        $kelasDipilih->rombel
                    )
                    ->orderBy('nama')
                    ->get();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Kehadiran Yang Sudah Pernah Disimpan
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('tanggal') &&
            $request->filled('kelas_id') &&
            $request->filled('mapel_id')
        ) {

            $kehadiranTersimpan = Kehadiran::where(
                    'tanggal',
                    $request->tanggal
                )
                ->where(
                    'kelas_id',
                    $request->kelas_id
                )
                ->where(
                    'mapel_id',
                    $request->mapel_id
                )
                ->where(
                    'jenis_absensi',
                    'Harian'
                )
                ->get()
                ->keyBy('siswa_id');
        }


        /*
        |--------------------------------------------------------------------------
        | Tampilkan View
        |--------------------------------------------------------------------------
        */

        return view(
            'kehadiran.input',
            compact(
                'kelas',
                'mapel',
                'siswas',
                'kehadiranTersimpan'
            )
        );
    }


    /**
     * Simpan / Update Kehadiran
     */
    public function simpan(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'tanggal' => 'required|date',

            'kelas_id' => 'required|exists:kelas,id',

            'mapel_id' => 'required|exists:mata_pelajarans,id',

            'siswa_id' => 'required|array|min:1',

            'siswa_id.*' => 'required|exists:siswas,id',

            'status' => 'required|array',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Mata Pelajaran
        |--------------------------------------------------------------------------
        */

        $mapel = MataPelajaran::findOrFail(
            $request->mapel_id
        );


        /*
        |--------------------------------------------------------------------------
        | Tentukan Guru
        |--------------------------------------------------------------------------
        */

        $guruId = Auth::user()->guru_id ?? null;


        /*
        | Jika user login bukan akun guru,
        | gunakan guru aktif pertama.
        */

        if (
            !$guruId ||
            !Guru::where('id', $guruId)->exists()
        ) {

            $guruId = Guru::where('aktif', 1)
                ->orderBy('id')
                ->value('id');
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Ada
        |--------------------------------------------------------------------------
        */

        if (!$guruId) {

            return back()
                ->withInput()
                ->withErrors([

                    'guru' =>
                    'Belum ada guru aktif yang dapat digunakan untuk menyimpan kehadiran.'

                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Semua Kehadiran
        |--------------------------------------------------------------------------
        */

        foreach (
            $request->siswa_id as $index => $siswaId
        ) {

            $status = $request->status[$index]
                ?? 'Hadir';


            /*
            | updateOrCreate memastikan:
            |
            | tanggal sama
            | siswa sama
            | mapel sama
            | jenis absensi sama
            |
            | = UPDATE
            |
            | bukan membuat record baru.
            */

            Kehadiran::updateOrCreate(

                [
                    'tanggal' => $request->tanggal,

                    'siswa_id' => $siswaId,

                    'mapel_id' => $mapel->id,

                    'jenis_absensi' => 'Harian',
                ],

                [
                    'guru_id' => $guruId,

                    'kelas_id' => $request->kelas_id,

                    'mata_pelajaran' =>
                        $mapel->nama_mapel,

                    'kegiatan' =>
                        'Absensi Manual',

                    'status' =>
                        $status,

                    'keterangan' =>
                        null,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Kembali ke Form Yang Sama
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'kehadiran.input',
                [
                    'tanggal' =>
                        $request->tanggal,

                    'kelas_id' =>
                        $request->kelas_id,

                    'mapel_id' =>
                        $request->mapel_id,
                ]
            )
            ->with(
                'success',
                'Kehadiran siswa berhasil disimpan.'
            );
    }
}
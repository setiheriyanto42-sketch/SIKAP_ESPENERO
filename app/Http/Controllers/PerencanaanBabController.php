<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerencanaanBab;
use App\Models\PerencanaanPembelajaran;

class PerencanaanBabController extends Controller
{
    public function create(Request $request)
    {
        $modul = PerencanaanPembelajaran::findOrFail(
            $request->modul
        );

        return view(
            'modul_bab.create',
            compact('modul')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'perencanaan_pembelajaran_id' => 'required',

            'nama_bab' => 'required',

            'tujuan' => 'nullable',

            'jumlah_pertemuan' => 'required|integer|min:1',

        ]);

        $urutan = PerencanaanBab::where(
            'perencanaan_pembelajaran_id',
            $request->perencanaan_pembelajaran_id
        )->count() + 1;

        PerencanaanBab::create([

            'perencanaan_pembelajaran_id' => $request->perencanaan_pembelajaran_id,

            'nama_bab' => $request->nama_bab,

            'tujuan' => $request->tujuan,

            'jumlah_pertemuan' => $request->jumlah_pertemuan,

            'urutan' => $urutan,

            'aktif' => 1,

        ]);

        

        return redirect()
            ->route(
                'modul-ajar.show',
                $request->perencanaan_pembelajaran_id
            )
            ->with(
                'success',
                'BAB berhasil ditambahkan.'
            );
    }

    public function edit(PerencanaanBab $bab)
    {
        return view(
            'modul_bab.edit',
            compact('bab')
        );
    }

    public function update(Request $request, PerencanaanBab $bab)
    {
        $request->validate([

            'nama_bab' => 'required',

            'tujuan' => 'nullable',

            'jumlah_pertemuan' => 'required|integer|min:1',

        ]);

        $bab->update([

            'nama_bab' => $request->nama_bab,

            'tujuan' => $request->tujuan,

            'jumlah_pertemuan' => $request->jumlah_pertemuan,

        ]);

        return redirect()
            ->route(
                'modul-ajar.show',
                $bab->perencanaan_pembelajaran_id
            )
            ->with(
                'success',
                'BAB berhasil diperbarui.'
            );
    }

    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | CARI BAB BERDASARKAN ID
        |--------------------------------------------------------------------------
        |
        | Kita ambil manual berdasarkan ID supaya tidak bergantung pada
        | nama parameter Route Model Binding.
        |
        */

        $bab = \App\Models\PerencanaanBab::with([
            'modul',
            'pertemuans'
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | PROTEKSI KEPEMILIKAN GURU
        |--------------------------------------------------------------------------
        |
        | Guru hanya boleh menghapus BAB dari Modul Ajar miliknya sendiri.
        |
        */

        $user = auth()->user();

        if (
            $user->guru_id &&
            $bab->modul &&
            $bab->modul->guru_id != $user->guru_id
        ) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus BAB ini.');
        }


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN MODUL INDUK ADA
        |--------------------------------------------------------------------------
        */

        $modulAjarId = $bab->perencanaan_pembelajaran_id;

        if (!$modulAjarId || !$bab->modul) {

            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'error',
                    'Modul induk dari BAB tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | JANGAN HAPUS BAB JIKA SUDAH MEMILIKI PERTEMUAN
        |--------------------------------------------------------------------------
        |
        | Ini penting supaya perencanaan pembelajaran tidak terhapus
        | secara tidak sengaja.
        |
        */

        if ($bab->pertemuans->count() > 0) {

            return redirect()
                ->route(
                    'modul-ajar.show',
                    [
                        'modulAjar' => $modulAjarId
                    ]
                )
                ->with(
                    'error',
                    'BAB tidak dapat dihapus karena sudah memiliki Pertemuan. Hapus Pertemuan terlebih dahulu jika BAB benar-benar ingin dihapus.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS BAB
        |--------------------------------------------------------------------------
        */

        $bab->delete();


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE DETAIL MODUL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'modul-ajar.show',
                [
                    'modulAjar' => $modulAjarId
                ]
            )
            ->with(
                'success',
                'BAB berhasil dihapus.'
            );
    }

}
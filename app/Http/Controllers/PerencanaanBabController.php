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

    public function destroy(PerencanaanBab $bab)
    {
        $modul = $bab->perencanaan_pembelajaran_id;

        $bab->delete();

        return redirect()
            ->route(
                'modul-ajar.show',
                $modul
            )
            ->with(
                'success',
                'BAB berhasil dihapus.'
            );
    }

}
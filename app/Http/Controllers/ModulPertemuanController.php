<?php

namespace App\Http\Controllers;

use App\Models\ModulBab;
use App\Models\ModulPertemuan;
use Illuminate\Http\Request;

class ModulPertemuanController extends Controller
{
    /**
     * Form tambah pertemuan.
     */
    public function create(ModulBab $bab)
    {
        $bab->load('modulAjar');

        $nomorBerikutnya =
            ((int) $bab->pertemuans()->max('nomor')) + 1;

        return view(
            'modul_ajar.pertemuan.create',
            compact(
                'bab',
                'nomorBerikutnya'
            )
        );
    }


    /**
     * Simpan pertemuan baru.
     */
    public function store(Request $request, ModulBab $bab)
    {
        $data = $request->validate([

            'tanggal' => [
                'nullable',
                'date',
            ],

            'jenis' => [
                'required',
                'string',
                'max:50',
            ],

            'tujuan' => [
                'nullable',
                'string',
            ],

            'materi' => [
                'nullable',
                'string',
            ],

            'aktivitas' => [
                'nullable',
                'string',
            ],

            'asesmen' => [
                'nullable',
                'string',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

        ]);


        $nomorBerikutnya =
            ((int) $bab->pertemuans()->max('nomor')) + 1;


        $data['modul_bab_id'] =
            $bab->id;

        $data['nomor'] =
            $nomorBerikutnya;


        ModulPertemuan::create($data);


        return redirect()
            ->route(
                'modul-ajar.show',
                $bab->modul_ajar_id
            )
            ->with(
                'success',
                'Pertemuan berhasil ditambahkan.'
            );
    }
}
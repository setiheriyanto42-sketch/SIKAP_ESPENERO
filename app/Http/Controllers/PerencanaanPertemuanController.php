<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerencanaanBab;
use App\Models\PerencanaanPertemuan;

class PerencanaanPertemuanController extends Controller
{
    public function generate(PerencanaanBab $bab)
    {
        if ($bab->pertemuans()->count() > 0) {
            return back()->with(
                'success',
                'Pertemuan sudah pernah dibuat.'
            );
        }

        for ($i = 1; $i <= $bab->jumlah_pertemuan; $i++) {

            PerencanaanPertemuan::create([

                'perencanaan_bab_id' => $bab->id,
                'pertemuan_ke'       => $i,
                'judul'              => 'Pertemuan ' . $i,
                'materi'             => '',
                'tujuan'             => '',
                'metode'             => '',
                'media'              => '',
                'lkpd'               => '',
                'asesmen'            => '',
                'catatan'            => '',
                'refleksi'           => '',
                'sudah_diajarkan'    => false,
                'ada_penilaian'      => false,

            ]);
        }

        return back()->with(
            'success',
            'Pertemuan berhasil dibuat.'
        );
    }

    public function show(PerencanaanPertemuan $pertemuan)
    {
        $pertemuan->load([
            'bab.modul',
        ]);

        return view(
            'modul_pertemuan.show',
            compact('pertemuan')
        );
    }

    public function update(
        Request $request,
        PerencanaanPertemuan $pertemuan
    ) {

        $validated = $request->validate([

            'judul'              => 'required|string|max:255',
            'tanggal'            => 'nullable|date',

            'materi'             => 'nullable|string',
            'tujuan'             => 'nullable|string',
            'metode'             => 'nullable|string',
            'media'              => 'nullable|string',

            'lkpd'               => 'nullable|string',
            'asesmen'            => 'nullable|string',
            'catatan'            => 'nullable|string',
            'refleksi'           => 'nullable|string',

            'sudah_diajarkan'    => 'nullable|boolean',
            'ada_penilaian'      => 'nullable|boolean',

        ]);

        $validated['sudah_diajarkan'] = $request->has('sudah_diajarkan');
        $validated['ada_penilaian']   = $request->has('ada_penilaian');

        $pertemuan->update($validated);

        return redirect()
            ->route('pertemuan.show', $pertemuan)
            ->with(
                'success',
                'Data pertemuan berhasil disimpan.'
            );
    }
}
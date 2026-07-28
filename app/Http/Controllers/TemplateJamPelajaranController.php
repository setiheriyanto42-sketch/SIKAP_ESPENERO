<?php

namespace App\Http\Controllers;

use App\Models\TemplateJamPelajaran;
use Illuminate\Http\Request;

class TemplateJamPelajaranController extends Controller
{
    public function index()
    {
        $templateJam = TemplateJamPelajaran::orderBy('nama_template')
            ->orderBy('urutan')
            ->get();

        return view('template_jam.index', compact('templateJam'));
    }

    public function create()
    {
        return view('template_jam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required',
            'jp' => 'nullable|integer',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis' => 'required',
            'urutan' => 'required|integer',
        ]);

        TemplateJamPelajaran::create([
            'template_jadwal_id' => 1,
            'nama_template'      => $request->nama_template,
            'jp'                 => $request->jp,
            'jam_mulai'          => $request->jam_mulai,
            'jam_selesai'        => $request->jam_selesai,
            'jenis'              => $request->jenis,
            'urutan'             => $request->urutan,
        ]);

        return redirect()
            ->route('template-jam.index')
            ->with('success', 'Data berhasil disimpan.');
    }

    public function edit(TemplateJamPelajaran $templateJam)
    {
        return view('template_jam.edit', compact('templateJam'));
    }

    public function update(Request $request, TemplateJamPelajaran $templateJam)
    {
        $request->validate([
            'nama_template' => 'required',
            'jp' => 'nullable|integer',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis' => 'required',
            'urutan' => 'required|integer',
        ]);

        $templateJam->update($request->all());

        return redirect()
            ->route('template-jam.index')
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy(TemplateJamPelajaran $templateJam)
    {
        $templateJam->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function generateKelas(PerencanaanPembelajaran $modulAjar)
    {
        $kelas = Kelas::where(
            'tingkat',
            $modulAjar->tingkat
        )->get();

        foreach ($kelas as $k) {

            PerencanaanKelas::firstOrCreate([

                'perencanaan_pembelajaran_id' => $modulAjar->id,

                'kelas_id' => $k->id,

            ]);

        }

        return back()->with(
            'success',
            'Semua kelas berhasil dibuat.'
        );
    }
}
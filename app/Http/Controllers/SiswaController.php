<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama')->get();

        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas',
            'nisn' => 'required|unique:siswas',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
            'rombel' => 'required',
        ]);

        Siswa::create([
            'nis'             => $request->nis,
            'nisn'            => $request->nisn,
            'nama'            => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'agama'           => $request->agama,
            'alamat'          => $request->alamat,
            'nama_ayah'       => $request->nama_ayah,
            'nama_ibu'        => $request->nama_ibu,
            'no_hp'           => $request->no_hp,
            'kelas'           => $request->kelas,
            'rombel'          => $request->rombel,
            'aktif'           => true,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    public function show(Siswa $siswa)
    {
        //
    }

    public function edit(Siswa $siswa)
    {
        //
    }

    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    public function destroy(Siswa $siswa)
    {
        //
    }
}

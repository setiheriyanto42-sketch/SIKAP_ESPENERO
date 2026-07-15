<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT SISWA
    |--------------------------------------------------------------------------
    */

    public function importForm()
    {
        return view('siswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new SiswaImport,
            $request->file('file')
        );

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate()
    {
        return Excel::download(
            new SiswaTemplateExport(),
            'Template_Siswa.xlsx'
        );
    }
}

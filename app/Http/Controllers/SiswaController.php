<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

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

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {

            $namaFile = time() . '_' . $request->nis . '.' .
                $request->file('foto')->getClientOriginalExtension();

            $foto = $request->file('foto')
                ->storeAs('siswa', $namaFile, 'public');
        }

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
            'foto'            => $foto,
            'aktif'           => true,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    public function show(Siswa $siswa)
    {
        return view(
            'siswa.show',
            compact('siswa')
        );
    }

    public function edit(Siswa $siswa)
    {
        return view(
            'siswa.edit',
            compact('siswa')
        );
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([

            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'required|unique:siswas,nisn,' . $siswa->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
            'rombel' => 'required',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $foto = $siswa->foto;

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $namaFile = time().'_'.$request->nis.'.'.$request->file('foto')->getClientOriginalExtension();

            $foto = $request->file('foto')->storeAs(
                'siswa',
                $namaFile,
                'public'
            );
        }

        $siswa->update([

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
            'foto'            => $foto,
            'aktif'           => $request->has('aktif'),

        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
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

<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruTemplateExport;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $gurus = Guru::orderBy('nama')->get();

    return view('guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'nullable|email|unique:gurus,email',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'aktif' => true,
        ]);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'nullable|email|unique:gurus,email,' . $guru->id,
        ]);

        $guru->update([
            'nip'             => $request->nip,
            'nama'            => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'no_hp'           => $request->no_hp,
            'email'           => $request->email,
            'alamat'          => $request->alamat,
            'aktif'           => $request->aktif,
        ]);

        return redirect()->route('guru.index')
                        ->with('success','Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function importForm()
        {
            return view('guru.import');
        }

        public function import(Request $request)
        {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);

            Excel::import(new GuruImport, $request->file('file'));

            return redirect()
                ->route('guru.index')
                ->with('success', 'Data guru berhasil diimport.');
        }
    public function destroy(Guru $guru)
        {
            $guru->delete();

            return redirect()
                ->route('guru.index')
                ->with('success', 'Data guru berhasil dihapus.');
        }

    public function downloadTemplate()
    {
        return Excel::download(
            new GuruTemplateExport(),
            'Template_Guru.xlsx'
        );
    }
}

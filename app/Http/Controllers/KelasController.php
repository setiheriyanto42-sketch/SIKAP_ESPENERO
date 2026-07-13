<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Daftar kelas
     */
    public function index()
    {
        $kelas = Kelas::with('guru')
                    ->orderBy('tingkat')
                    ->orderBy('rombel')
                    ->get();

        return view('kelas.index', compact('kelas'));
    }

    /**
     * Form tambah kelas
     */
    public function create()
    {
        $gurus = Guru::where('aktif', 1)
                    ->orderBy('nama')
                    ->get();

        return view('kelas.create', compact('gurus'));
    }

    /**
     * Simpan kelas
     */
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|numeric',
            'rombel' => 'required|max:2',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        Kelas::create([
            'tingkat'     => $request->tingkat,
            'rombel'      => strtoupper($request->rombel),
            'nama_kelas'  => $request->tingkat . strtoupper($request->rombel),
            'guru_id'     => $request->guru_id,
            'wali_kelas'  => null, // sementara tetap ada agar kompatibel
            'aktif'       => true,
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Detail kelas
     */
    public function show(Kelas $kelas)
    {
        return redirect()->route('kelas.index');
    }

    /**
     * Form edit kelas
     */
    public function edit(Kelas $kelas)
    {
        $gurus = Guru::where('aktif', 1)
                    ->orderBy('nama')
                    ->get();

        return view('kelas.edit', compact('kelas', 'gurus'));
    }

    /**
     * Update kelas
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'tingkat' => 'required|numeric',
            'rombel' => 'required|max:2',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        $kelas->update([
            'tingkat'     => $request->tingkat,
            'rombel'      => strtoupper($request->rombel),
            'nama_kelas'  => $request->tingkat . strtoupper($request->rombel),
            'guru_id'     => $request->guru_id,
            'aktif'       => $request->has('aktif'),
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Hapus kelas
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}

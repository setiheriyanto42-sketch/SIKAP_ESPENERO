<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;

class GuruMengajarController extends Controller
{
    public function index()
    {
        $mengajar = GuruMengajar::with([
            'guru',
            'kelas',
            'mataPelajaran'
        ])->latest()->get();

        return view('guru_mengajar.index', compact('mengajar'));
    }

    public function create()
    {
        $gurus = Guru::where('aktif', 1)
            ->orderBy('nama')
            ->get();

        $kelas = Kelas::where('aktif', 1)
            ->orderBy('tingkat')
            ->orderBy('rombel')
            ->get();

        $mapel = MataPelajaran::where('aktif', 1)
            ->orderBy('nama_mapel')
            ->get();

        return view('guru_mengajar.create', compact(
            'gurus',
            'kelas',
            'mapel'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        GuruMengajar::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'aktif' => true,
        ]);

        return redirect()
            ->route('guru-mengajar.index')
            ->with('success', 'Penugasan berhasil disimpan.');
    }

    public function show(GuruMengajar $guruMengajar)
    {
        return redirect()->route('guru-mengajar.index');
    }

    public function edit(GuruMengajar $guruMengajar)
    {
        //
    }

    public function update(Request $request, GuruMengajar $guruMengajar)
    {
        //
    }

    public function destroy(GuruMengajar $guruMengajar)
    {
        $guruMengajar->delete();

        return back()->with(
            'success',
            'Penugasan berhasil dihapus.'
        );
    }
}
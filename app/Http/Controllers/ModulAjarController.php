<?php

namespace App\Http\Controllers;

use App\Models\ModulAjar;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class ModulAjarController extends Controller
{
    /**
     * DAFTAR MODUL AJAR
     */
    public function index()
    {
        $data = ModulAjar::withCount('bab')
            ->latest()
            ->paginate(10);

        return view(
            'modul_ajar.index',
            compact('data')
        );
    }

    /**
     * Form Susun Manual.
     */
    public function create()
    {
        $user = auth()->user();

        abort_unless($user, 403);

        // Mata pelajaran aktif
        $mapel = MataPelajaran::where('aktif', true)
            ->orderBy('nama_mapel')
            ->get();

        // Tahun ajaran aktif
        $tahun = TahunAjaran::where('aktif', true)
            ->first();

        // Tingkat kelas
        $tingkats = collect([7, 8, 9]);

        return view(
            'modul_ajar.create',
            compact(
                'mapel',
                'tahun',
                'tingkats'
            )
        );
    }

    /**
     * DETAIL MODUL AJAR
     */
    public function show(ModulAjar $modulAjar)
    {
        $this->authorizeModul($modulAjar);

        $modulAjar->load([
            'guru',
            'bab.pertemuans',
        ]);

        return view(
            'modul_ajar.detail-ai',
            compact('modulAjar')
        );
    }

    /**
     * FORM EDIT
     */
    public function edit(ModulAjar $modulAjar)
    {
        $this->authorizeModul($modulAjar);

        return view(
            'modul_ajar.edit',
            compact('modulAjar')
        );
    }

    /**
     * UPDATE
     */
    public function update(
        \Illuminate\Http\Request $request,
        ModulAjar $modulAjar
    ) {
        $this->authorizeModul($modulAjar);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:2000',
        ]);

        $modulAjar->update([
            'judul' => $validated['judul'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('modul-ajar.show', $modulAjar)
            ->with(
                'success',
                'Modul Ajar berhasil diperbarui.'
            );
    }

    /**
     * HAPUS
     */
    public function destroy(ModulAjar $modulAjar)
    {
        $this->authorizeModul($modulAjar);

        $modulAjar->delete();

        return redirect()
            ->route('modul-ajar.index')
            ->with(
                'success',
                'Modul Ajar berhasil dihapus.'
            );
    }

    /**
     * KEAMANAN
     */
    private function authorizeModul(ModulAjar $modul): void
    {
        $user = auth()->user();

        // Admin bebas
        if ($user->isAdmin()) {
            return;
        }

        // Guru hanya boleh membuka modul miliknya
        if (
            $user->guru_id &&
            (int) $modul->guru_id === (int) $user->guru_id
        ) {
            return;
        }

        abort(
            403,
            'Anda tidak memiliki akses ke Modul Ajar ini.'
        );
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user, 403);

        $validated = $request->validate([
            'mata_pelajaran_id' => ['required', 'integer', 'exists:mata_pelajarans,id'],
            'tingkat'           => ['required', 'string'],
            'judul'             => ['required', 'string', 'max:255'],
            'keterangan'        => ['nullable', 'string'],
        ]);

        // Mata pelajaran dari ID form
        $mataPelajaran = MataPelajaran::findOrFail(
            $validated['mata_pelajaran_id']
        );

        // Tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        abort_unless(
            $tahunAjaran,
            422,
            'Tahun ajaran aktif belum tersedia.'
        );

        $modulAjar = new ModulAjar();

        // Guru pemilik modul
        $modulAjar->guru_id = $user->guru_id;

        // Data akademik
        $modulAjar->mata_pelajaran = $mataPelajaran->nama_mapel;
        $modulAjar->kelas = $validated['tingkat'];
        $modulAjar->semester = $tahunAjaran->semester;
        $modulAjar->tahun_ajaran = $tahunAjaran->tahun_ajaran;

        // Data modul
        $modulAjar->judul = $validated['judul'];
        $modulAjar->keterangan = $validated['keterangan'] ?? null;

        $modulAjar->save();

        return redirect()
            ->route('modul-ajar.index')
            ->with('success', 'Modul Ajar berhasil dibuat.');
    }
}
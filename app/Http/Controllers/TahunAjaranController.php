<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahun = TahunAjaran::orderByDesc('aktif')
                    ->orderByDesc('id')
                    ->get();

        return view('tahun_ajaran.index', compact('tahun'));
    }

    public function create()
    {
        return view('tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        dd('MASUK STORE');

        $request->validate([
            'tahun_ajaran' => 'required|max:20',
            'semester' => 'required',
        ]);

        if ($request->has('aktif')) {
            TahunAjaran::query()->update([
                'aktif' => false,
            ]);
        }

        TahunAjaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()
            ->route('tahun-ajaran.index')
            ->with(
                'success',
                '✅ Tahun Ajaran berhasil ditambahkan.'
            );
    }



    public function show(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun-ajaran.index');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_ajaran'=>'required|max:20',
            'semester'=>'required',
        ]);

        if ($request->has('aktif')) {
            TahunAjaran::query()->update([
                'aktif'=>false
            ]);
        }

        $tahunAjaran->update([
            'tahun_ajaran'=>$request->tahun_ajaran,
            'semester'=>$request->semester,
            'aktif'=>$request->has('aktif'),
        ]);

        return redirect()
        ->route('tahun-ajaran.index')
        ->with(
            'success',
            '✅ Data Tahun Ajaran berhasil diperbarui'.
            ($request->has('aktif')
                ? ' dan sekarang menjadi Tahun Ajaran Aktif.'
                : '.')
        );
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return back()
            ->with('success','Data berhasil dihapus.');
    }
}

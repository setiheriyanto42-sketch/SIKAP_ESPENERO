<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    public function index()
    {
        $jadwal = JadwalMengajar::with([
            'guruMengajar.guru',
            'guruMengajar.kelas',
            'guruMengajar.mataPelajaran'
        ])
        ->orderBy('hari')
        ->orderBy('jam_ke')
        ->get();

        return view('jadwal_mengajar.index', compact('jadwal'));
    }

    public function create()
    {
        $mengajar = GuruMengajar::with([
            'guru',
            'kelas',
            'mataPelajaran'
        ])
        ->where('aktif',1)
        ->get();

        return view('jadwal_mengajar.create', compact('mengajar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_mengajar_id'=>'required|exists:guru_mengajars,id',
            'hari'=>'required',
            'jam_ke'=>'required|numeric',
            'jam_mulai'=>'required',
            'jam_selesai'=>'required',
        ]);

        JadwalMengajar::create([
            'guru_mengajar_id'=>$request->guru_mengajar_id,
            'hari'=>$request->hari,
            'jam_ke'=>$request->jam_ke,
            'jam_mulai'=>$request->jam_mulai,
            'jam_selesai'=>$request->jam_selesai,
            'aktif'=>true,
        ]);

        return redirect()
            ->route('jadwal-mengajar.index')
            ->with('success','Jadwal berhasil disimpan.');
    }

    public function show(JadwalMengajar $jadwalMengajar)
    {
        return redirect()->route('jadwal-mengajar.index');
    }

    public function edit(JadwalMengajar $jadwalMengajar)
    {
        $mengajar = GuruMengajar::with([
            'guru',
            'kelas',
            'mataPelajaran'
        ])
        ->where('aktif',1)
        ->get();

        return view('jadwal_mengajar.edit', compact('jadwalMengajar','mengajar'));
    }

    public function update(Request $request, JadwalMengajar $jadwalMengajar)
    {
        $request->validate([
            'guru_mengajar_id'=>'required|exists:guru_mengajars,id',
            'hari'=>'required',
            'jam_ke'=>'required|numeric',
            'jam_mulai'=>'required',
            'jam_selesai'=>'required',
        ]);

        $jadwalMengajar->update([
            'guru_mengajar_id'=>$request->guru_mengajar_id,
            'hari'=>$request->hari,
            'jam_ke'=>$request->jam_ke,
            'jam_mulai'=>$request->jam_mulai,
            'jam_selesai'=>$request->jam_selesai,
        ]);

        return redirect()
            ->route('jadwal-mengajar.index')
            ->with('success','Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalMengajar $jadwalMengajar)
    {
        $jadwalMengajar->delete();

        return back()->with('success','Jadwal berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalMengajar::with([
            'guruMengajar.guru',
            'guruMengajar.kelas',
            'guruMengajar.mataPelajaran'
        ]);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('guru')) {
            $query->whereHas('guruMengajar', function ($q) use ($request) {
                $q->where('guru_id', $request->guru);
            });
        }

        if ($request->filled('kelas')) {
            $query->whereHas('guruMengajar', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('guruMengajar', function ($q) use ($search) {

                $q->whereHas('guru', function ($g) use ($search) {
                    $g->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('mataPelajaran', function ($m) use ($search) {
                    $m->where('nama_mapel', 'like', "%{$search}%");
                });

            });

        }

        $jadwal = $query
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get();

        return view('jadwal_mengajar.index', [
            'jadwal' => $jadwal,
            'gurus' => \App\Models\Guru::orderBy('nama')->get(),
            'kelas' => \App\Models\Kelas::orderBy('tingkat')->get(),
        ]);
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
            'guru_mengajar_id' => 'required|exists:guru_mengajars,id',
            'hari'             => 'required',
            'jam_ke'           => 'required|integer|min:1',
        ]);

        $guruMengajar = GuruMengajar::findOrFail(
            $request->guru_mengajar_id
        );

        /*
        |--------------------------------------------------------------------------
        | AMBIL TEMPLATE JADWAL AKTIF
        |--------------------------------------------------------------------------
        */

        $template = \App\Models\TemplateJadwal::where('aktif', 1)->first();

        if (!$template) {

            return back()
                ->withInput()
                ->withErrors([
                    'jam_ke' => 'Template Jadwal aktif belum tersedia.'
                ]);

        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL JAM PELAJARAN BERDASARKAN JP
        |--------------------------------------------------------------------------
        */

        $jamPelajaran = \App\Models\TemplateJamPelajaran::where(
            'template_jadwal_id',
            $template->id
        )
        ->where('jenis', 'belajar')
        ->where('urutan', $request->jam_ke)
        ->first();

        if (!$jamPelajaran) {

            return back()
                ->withInput()
                ->withErrors([
                    'jam_ke' => 'JP ' . $request->jam_ke .
                        ' tidak ditemukan pada Template Jadwal aktif.'
                ]);

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI GURU BENTROK
        |--------------------------------------------------------------------------
        */

        $guruBentrok = JadwalMengajar::where('hari', $request->hari)
            ->where('jam_ke', $request->jam_ke)
            ->whereHas('guruMengajar', function ($q) use ($guruMengajar) {

                $q->where('guru_id', $guruMengajar->guru_id);

            })
            ->exists();

        if ($guruBentrok) {

            return back()
                ->withInput()
                ->withErrors([
                    'guru_mengajar_id' =>
                        'Guru sudah memiliki jadwal pada hari dan JP tersebut.'
                ]);

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KELAS BENTROK
        |--------------------------------------------------------------------------
        */

        $kelasBentrok = JadwalMengajar::where('hari', $request->hari)
            ->where('jam_ke', $request->jam_ke)
            ->whereHas('guruMengajar', function ($q) use ($guruMengajar) {

                $q->where('kelas_id', $guruMengajar->kelas_id);

            })
            ->exists();

        if ($kelasBentrok) {

            return back()
                ->withInput()
                ->withErrors([
                    'guru_mengajar_id' =>
                        'Kelas sudah memiliki jadwal pada hari dan JP tersebut.'
                ]);

        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN JADWAL
        |--------------------------------------------------------------------------
        | Jam diambil langsung dari Template Jam Pelajaran.
        */

        JadwalMengajar::create([

            'guru_mengajar_id' => $guruMengajar->id,

            'hari'             => $request->hari,

            'jam_ke'           => $request->jam_ke,

            'jam_mulai'        => $jamPelajaran->jam_mulai,

            'jam_selesai'      => $jamPelajaran->jam_selesai,

            'aktif'            => true,

        ]);

        return redirect()
            ->route('jadwal-mengajar.index')
            ->with(
                'success',
                'Jadwal berhasil disimpan.'
            );
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

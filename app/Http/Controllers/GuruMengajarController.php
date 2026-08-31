<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;
use App\Models\TemplateJadwal;
use App\Models\TemplateJamPelajaran;
use App\Models\JadwalMengajar;
use Carbon\Carbon;


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
            'jumlah_jam' => 'required|integer|min:1|max:20',
        ]);

        GuruMengajar::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'jumlah_jam' => $request->jumlah_jam,
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

        return view('guru_mengajar.edit', compact(
            'guruMengajar',
            'gurus',
            'kelas',
            'mapel'
        ));
    }

    public function update(Request $request, GuruMengajar $guruMengajar)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jumlah_jam' => 'required|integer|min:1|max:20',
        ]);

        $guruMengajar->update([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'jumlah_jam' => $request->jumlah_jam,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()
            ->route('guru-mengajar.index')
            ->with('success', 'Penugasan berhasil diperbarui.');
    }

    public function destroy(GuruMengajar $guruMengajar)
    {
        $guruMengajar->delete();

        return back()->with(
            'success',
            'Penugasan berhasil dihapus.'
        );
    }

    public function generate()
    {
        $mengajar = GuruMengajar::with([
            'guru',
            'kelas',
            'mataPelajaran'
        ])
        ->where('aktif',1)
        ->orderBy('guru_id')
        ->get();

        return view(
            'guru_mengajar.generate',
            compact('mengajar')
        );
    }

    public function generateSemua()
    {
        $template = TemplateJadwal::where('aktif', 1)->first();

        if (!$template) {
            return back()->with(
                'error',
                'Template Jadwal belum dipilih.'
            );
        }

        $jamPelajaran = TemplateJamPelajaran::where(
            'template_jadwal_id',
            $template->id
        )
        ->where('jenis', 'belajar')
        ->orderBy('urutan')
        ->get()
        ->values();

        if ($jamPelajaran->count() == 0) {

            return back()->with(
                'error',
                'Silakan Generate Template terlebih dahulu.'
            );

        }

        $guruMengajar = GuruMengajar::with([
            'guru',
            'kelas',
            'mataPelajaran'
        ])
        ->where('aktif',1)
        ->orderBy('guru_id')
        ->get();

        if($guruMengajar->count()==0){

            return back()->with(
                'error',
                'Belum ada penugasan guru.'
            );

        }

        JadwalMengajar::query()->delete();

        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        $hariIndex = 0;
        $jpIndex = 0;

        foreach($guruMengajar as $item){

            $sisa = $item->jumlah_jam;

            while($sisa>0){

                if($jpIndex >= $jamPelajaran->count()){

                    $jpIndex = 0;
                    $hariIndex++;

                }

                if($hariIndex >= count($hari)){

                    break 2;

                }

                $jp = $jamPelajaran[$jpIndex];

                JadwalMengajar::create([

                    'guru_mengajar_id'=>$item->id,

                    'hari'=>$hari[$hariIndex],

                    'jam_ke'=>$jpIndex+1,

                    'jam_mulai'=>$jp->jam_mulai,

                    'jam_selesai'=>$jp->jam_selesai,

                    'aktif'=>true,

                ]);

                $jpIndex++;
                $sisa--;

            }

        }

        return redirect()
            ->route('jadwal-mengajar.index')
            ->with(
                'success',
                'Generate Jadwal berhasil.'
            );

    }

}
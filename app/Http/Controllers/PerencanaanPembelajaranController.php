<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\GuruMengajar;
use App\Models\PerencanaanKelas;
use App\Models\PerencanaanPembelajaran;
use App\Models\TahunAjaran;
use App\Models\ModulAjar;


class PerencanaanPembelajaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR MODUL AJAR
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = \App\Models\ModulAjar::withCount('bab')
            ->latest()
            ->paginate(10);

        return view(
            'modul_ajar.index',
            compact('data')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH MODUL
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | TAHUN AJARAN AKTIF
        |--------------------------------------------------------------------------
        */
        $tahun = TahunAjaran::where('aktif', 1)->first();

        if (!$tahun) {
            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'error',
                    'Belum ada Tahun Ajaran Aktif.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */
        $gurus = collect();
        $mapel = collect();
        $tingkats = collect([7, 8, 9]);


        /*
        |--------------------------------------------------------------------------
        | JIKA LOGIN SEBAGAI GURU
        |--------------------------------------------------------------------------
        |
        | Guru hanya boleh melihat:
        |
        | - mata pelajaran yang ditugaskan kepadanya
        | - tingkat kelas yang ditugaskan kepadanya
        |
        */
        if ($user->guru_id) {

            $penugasans = GuruMengajar::with([
                    'mataPelajaran',
                    'kelas',
                ])
                ->where('guru_id', $user->guru_id)
                ->get();

            /*
            |--------------------------------------------------------------------------
            | MAPEL YANG DIAJAR GURU
            |--------------------------------------------------------------------------
            */
            $mapel = $penugasans
                ->pluck('mataPelajaran')
                ->filter()
                ->unique('id')
                ->sortBy('nama_mapel')
                ->values();

            /*
            |--------------------------------------------------------------------------
            | TINGKAT YANG DIAJAR GURU
            |--------------------------------------------------------------------------
            */
            $tingkats = $penugasans
                ->pluck('kelas.tingkat')
                ->filter()
                ->unique()
                ->sort()
                ->values();

        } else {

            /*
            |--------------------------------------------------------------------------
            | ADMIN / USER TANPA GURU_ID
            |--------------------------------------------------------------------------
            */
            $mapel = MataPelajaran::where('aktif', 1)
                ->orderBy('nama_mapel')
                ->get();

            $gurus = Guru::where('aktif', 1)
                ->orderBy('nama')
                ->get();

            $tingkats = collect([7, 8, 9]);
        }


        return view(
            'modul_ajar.create',
            compact(
                'mapel',
                'tahun',
                'gurus',
                'tingkats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN MODUL AJAR
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'mata_pelajaran_id' =>
                'required|exists:mata_pelajarans,id',

            'tingkat' =>
                'required|in:7,8,9',

            'judul' =>
                'required|string|max:255',

            'keterangan' =>
                'nullable|string',

            'guru_id' =>
                'nullable|exists:gurus,id',
        ]);

        // Tahun ajaran aktif
        $tahun = TahunAjaran::where('aktif', 1)->first();

        if (!$tahun) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Belum ada Tahun Ajaran Aktif.'
                );
        }

        // Tentukan guru
        if ($user->guru_id) {
            $guruId = $user->guru_id;
        } else {
            $guruId = $request->guru_id;
        }

        if (!$guruId) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Guru belum ditentukan.'
                );
        }

        // Jika login sebagai guru,
        // pastikan memang mengajar mapel + tingkat tersebut
        if ($user->guru_id) {

            $punyaPenugasan = GuruMengajar::where(
                'guru_id',
                $user->guru_id
            )
                ->where(
                    'mata_pelajaran_id',
                    $request->mata_pelajaran_id
                )
                ->whereHas(
                    'kelas',
                    function ($query) use ($request) {

                        $query->where(
                            'tingkat',
                            $request->tingkat
                        );
                    }
                )
                ->exists();

            if (!$punyaPenugasan) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Anda tidak memiliki penugasan mengajar untuk mata pelajaran dan tingkat tersebut.'
                    );
            }
        }

        // Ambil data mapel
        $mataPelajaran = MataPelajaran::findOrFail(
            $request->mata_pelajaran_id
        );

        $semester = $tahun->semester;

        /*
        |--------------------------------------------------------------------------
        | CEGAH DUPLIKAT
        |--------------------------------------------------------------------------
        */
        $modulSudahAda = ModulAjar::where(
            'guru_id',
            $guruId
        )
            ->where(
                'mata_pelajaran',
                $mataPelajaran->nama_mapel
            )
            ->where(
                'kelas',
                $request->tingkat
            )
            ->where(
                'semester',
                $semester
            )
            ->where(
                'tahun_ajaran',
                $tahun->tahun_ajaran
            )
            ->exists();

        if ($modulSudahAda) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Modul Ajar untuk Guru, Mata Pelajaran, Tingkat, Tahun Ajaran, dan Semester tersebut sudah tersedia. Silakan buka modul yang sudah ada dan tambahkan BAB atau Pertemuan di dalamnya.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE MODUL_AJARS
        |--------------------------------------------------------------------------
        */
        $modul = ModulAjar::create([

            'guru_id' =>
                $guruId,

            'nama_file' =>
                null,

            'mata_pelajaran' =>
                $mataPelajaran->nama_mapel,

            'kelas' =>
                $request->tingkat,

            'fase' =>
                'D',

            'semester' =>
                $semester,

            'tahun_ajaran' =>
                $tahun->tahun_ajaran,

            'alokasi_waktu' => [
                'teks' => 'Belum ditentukan',
                'jp' => 0,
                'menit_per_jp' => 40,
                'total_menit' => 0,
            ],

            'judul' =>
                $request->judul,

            'keterangan' =>
                $request->keterangan,

            'aktif' =>
                true,
        ]);

        return redirect()
            ->route(
                'modul-ajar.show',
                $modul
            )
            ->with(
                'success',
                'Modul Ajar berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL MODUL AJAR
    |--------------------------------------------------------------------------
    */
    public function show(ModulAjar $modulAjar)
    {
        $this->authorizeModul($modulAjar);

        $modulAjar->load([
            'guru',
            'bab.pertemuans',
        ]);

        $kelas = Kelas::where(
            'tingkat',
            $modulAjar->kelas
        )
            ->orderBy('rombel')
            ->get();

        return view(
            'modul_ajar.show',
            compact(
                'modulAjar',
                'kelas'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT MODUL AJAR
    |--------------------------------------------------------------------------
    */
    public function edit(ModulAjar $modulAjar)
    {
        $this->authorizeModul($modulAjar);

        $modulAjar->load([
            'guru',
        ]);

        return view(
            'modul_ajar.edit',
            compact('modulAjar')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MODUL AJAR
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
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


    /*
    |--------------------------------------------------------------------------
    | HAPUS MODUL AJAR
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | GENERATE KELAS
    |--------------------------------------------------------------------------
    */
    public function generateKelas(
        PerencanaanPembelajaran $modulAjar
    ) {
        /*
        |--------------------------------------------------------------------------
        | KEAMANAN KEPEMILIKAN MODUL
        |--------------------------------------------------------------------------
        */
        $this->authorizeModul($modulAjar);


        /*
        |--------------------------------------------------------------------------
        | AMBIL KELAS BERDASARKAN PENUGASAN GURU
        |--------------------------------------------------------------------------
        |
        | Hanya kelas yang:
        |
        | - diampu guru pemilik modul
        | - mata pelajarannya sama
        | - tingkatnya sama dengan modul
        | - penugasannya aktif
        |
        */
        $penugasans = GuruMengajar::with('kelas')
            ->where(
                'guru_id',
                $modulAjar->guru_id
            )
            ->where(
                'mata_pelajaran_id',
                $modulAjar->mata_pelajaran_id
            )
            ->where(
                'aktif',
                true
            )
            ->whereHas(
                'kelas',
                function ($query) use ($modulAjar) {

                    $query->where(
                        'tingkat',
                        $modulAjar->tingkat
                    );
                }
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA PENUGASAN
        |--------------------------------------------------------------------------
        */
        if ($penugasans->isEmpty()) {

            return back()->with(
                'error',
                'Tidak ditemukan kelas yang sesuai dengan penugasan mengajar guru.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL ID KELAS YANG SAH
        |--------------------------------------------------------------------------
        */
        $kelasIds = $penugasans
            ->pluck('kelas_id')
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | HAPUS HUBUNGAN KELAS YANG SUDAH TIDAK SESUAI
        |--------------------------------------------------------------------------
        |
        | Penting karena sebelumnya sistem pernah memasukkan
        | semua kelas dalam satu tingkat.
        |
        */
        PerencanaanKelas::where(
            'perencanaan_pembelajaran_id',
            $modulAjar->id
        )
        ->whereNotIn(
            'kelas_id',
            $kelasIds
        )
        ->delete();


        /*
        |--------------------------------------------------------------------------
        | SINKRONKAN KELAS YANG BENAR
        |--------------------------------------------------------------------------
        */
        foreach ($kelasIds as $kelasId) {

            PerencanaanKelas::firstOrCreate([

                'perencanaan_pembelajaran_id' =>
                    $modulAjar->id,

                'kelas_id' =>
                    $kelasId,

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'success',
            'Kelas pengguna Modul Ajar berhasil disinkronkan dengan penugasan mengajar.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KEAMANAN KEPEMILIKAN MODUL
    |--------------------------------------------------------------------------
    |
    | Guru tidak boleh membuka / mengubah / menghapus modul guru lain
    | meskipun mencoba mengganti ID melalui URL.
    |
    */
    private function authorizeModul(
        ModulAjar $modul
    ): void {
        $user = auth()->user();

        // ADMIN bebas mengakses semua Modul Ajar
        if ($user->isAdmin()) {
            return;
        }

        // GURU hanya boleh mengakses Modul Ajar miliknya
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
}
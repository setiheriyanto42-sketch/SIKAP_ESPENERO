<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PerencanaanKelas;
use App\Models\PerencanaanPembelajaran;
use App\Models\TahunAjaran;

class PerencanaanPembelajaranController extends Controller
{
    public function index()
    {
        $data = PerencanaanPembelajaran::with([
            'guru',
            'mataPelajaran',
            'tahunAjaran',
            'kelas',
            'babs.pertemuans',
        ])
        ->latest()
        ->paginate(10);

        return view(
            'modul_ajar.index',
            compact('data')
        );
    }

    public function create()
    {
        $mapel = MataPelajaran::where('aktif',1)
            ->orderBy('nama_mapel')
            ->get();

        $tahun = TahunAjaran::where('aktif',1)->first();

        $gurus = Guru::where('aktif',1)
            ->orderBy('nama')
            ->get();

        return view(
            'modul_ajar.create',
            compact(
                'mapel',
                'tahun',
                'gurus'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'mata_pelajaran_id'=>'required|exists:mata_pelajarans,id',

            'tingkat'=>'required',

            'semester'=>'required',

            'judul'=>'required|max:255',

            'keterangan'=>'nullable',

            'guru_id'=>'nullable|exists:gurus,id',

        ]);

        $tahun = TahunAjaran::where('aktif',1)->first();

        if(!$tahun){

            return back()
                ->with('error','Belum ada Tahun Ajaran Aktif.');

        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Tentukan Guru
        |--------------------------------------------------------------------------
        */

        $guruId = $user->guru_id;

        if(!$guruId){

            $guruId = $request->guru_id;

        }

        if(!$guruId){

            return back()
                ->withInput()
                ->with('error','Silakan pilih guru terlebih dahulu.');

        }

        $modul = PerencanaanPembelajaran::create([

            'guru_id'=>$guruId,

            'mata_pelajaran_id'=>$request->mata_pelajaran_id,

            'tahun_ajaran_id'=>$tahun->id,

            'tingkat'=>$request->tingkat,

            'semester'=>$request->semester,

            'judul'=>$request->judul,

            'keterangan'=>$request->keterangan,

            'aktif'=>true,

        ]);

        return redirect()
            ->route('modul-ajar.show',$modul)
            ->with(
                'success',
                'Modul Ajar berhasil dibuat.'
            );
    }

    public function show(PerencanaanPembelajaran $modulAjar)
    {
        $modulAjar->load([

            'guru',

            'mataPelajaran',

            'tahunAjaran',

            'kelas.kelas',

            'babs',

        ]);

        $kelas = Kelas::where(
                'tingkat',
                $modulAjar->tingkat
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

    public function edit(PerencanaanPembelajaran $modulAjar)
    {
        //
    }

    public function update(Request $request, PerencanaanPembelajaran $modulAjar)
    {
        //
    }

    public function destroy(PerencanaanPembelajaran $modulAjar)
    {
        $modulAjar->delete();

        return back()->with(
            'success',
            'Modul berhasil dihapus.'
        );
    }

    public function generateKelas(
    PerencanaanPembelajaran $modulAjar
    )
    {

        $kelas = Kelas::where(
            'tingkat',
            $modulAjar->tingkat
        )->get();

        foreach($kelas as $k){

            PerencanaanKelas::firstOrCreate(

                [

                    'perencanaan_pembelajaran_id'=>$modulAjar->id,

                    'kelas_id'=>$k->id,

                ]

            );

        }

        return back()->with(

            'success',

            'Semua kelas berhasil ditambahkan.'

        );

    }
}
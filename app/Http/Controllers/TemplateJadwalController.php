<?php

namespace App\Http\Controllers;

use App\Models\TemplateJadwal;
use Illuminate\Http\Request;
use App\Models\TemplateJamPelajaran;
use Carbon\Carbon;

class TemplateJadwalController extends Controller
{
    public function index()
    {
        $templates = TemplateJadwal::orderBy('nama')->get();

        return view('template_jadwal.index', compact('templates'));
    }

    public function create()
    {
        return view('template_jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'durasi_jp' => 'required|integer|min:1',
            'jam_masuk' => 'required',
            'jumlah_jp' => 'required|integer|min:1',
        ]);

        TemplateJadwal::create([
            'nama' => $request->nama,
            'durasi_jp' => $request->durasi_jp,
            'jam_masuk' => $request->jam_masuk,
            'jumlah_jp' => $request->jumlah_jp,
            'istirahat_setelah' => $request->istirahat_setelah,
            'durasi_istirahat' => $request->durasi_istirahat,
            'ishoma_setelah' => $request->ishoma_setelah,
            'durasi_ishoma' => $request->durasi_ishoma,
            'aktif' => $request->has('aktif'),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('template-jadwal.index')
            ->with('success', 'Template jadwal berhasil disimpan.');
    }

    public function generate(TemplateJadwal $templateJadwal)
    {
        TemplateJamPelajaran::where(
            'template_jadwal_id',
            $templateJadwal->id
        )->delete();

        $jam = Carbon::createFromFormat(
            'H:i:s',
            $templateJadwal->jam_masuk
        );

        $urutan = 1;

        // Sambut Pagi
        TemplateJamPelajaran::create([
            'template_jadwal_id' => $templateJadwal->id,
            'nama_template' => $templateJadwal->nama,
            'jp' => 10,
            'jam_mulai' => $jam->format('H:i'),
            'jam_selesai' => $jam->copy()->addMinutes(10)->format('H:i'),
            'jenis' => 'sambut_pagi',
            'urutan' => $urutan++,
        ]);

        $jam->addMinutes(10);

        // Pembiasaan
        TemplateJamPelajaran::create([
            'template_jadwal_id' => $templateJadwal->id,
            'nama_template' => $templateJadwal->nama,
            'jp' => 10,
            'jam_mulai' => $jam->format('H:i'),
            'jam_selesai' => $jam->copy()->addMinutes(10)->format('H:i'),
            'jenis' => 'pembiasaan',
            'urutan' => $urutan++,
        ]);

        $jam->addMinutes(10);

        for ($i = 1; $i <= $templateJadwal->jumlah_jp; $i++) {

            TemplateJamPelajaran::create([
                'template_jadwal_id' => $templateJadwal->id,
                'nama_template' => $templateJadwal->nama,
                'jp' => $templateJadwal->durasi_jp,
                'jam_mulai' => $jam->format('H:i'),
                'jam_selesai' => $jam->copy()
                    ->addMinutes($templateJadwal->durasi_jp)
                    ->format('H:i'),
                'jenis' => 'belajar',
                'urutan' => $urutan++,
            ]);

            $jam->addMinutes($templateJadwal->durasi_jp);

            if ($i == $templateJadwal->istirahat_setelah) {

                TemplateJamPelajaran::create([
                    'template_jadwal_id' => $templateJadwal->id,
                    'nama_template' => $templateJadwal->nama,
                    'jp' => $templateJadwal->durasi_istirahat,
                    'jam_mulai' => $jam->format('H:i'),
                    'jam_selesai' => $jam->copy()
                        ->addMinutes($templateJadwal->durasi_istirahat)
                        ->format('H:i'),
                    'jenis' => 'istirahat',
                    'urutan' => $urutan++,
                ]);

                $jam->addMinutes(
                    $templateJadwal->durasi_istirahat
                );
            }

            if ($i == $templateJadwal->ishoma_setelah) {

                TemplateJamPelajaran::create([
                    'template_jadwal_id' => $templateJadwal->id,
                    'nama_template' => $templateJadwal->nama,
                    'jp' => $templateJadwal->durasi_ishoma,
                    'jam_mulai' => $jam->format('H:i'),
                    'jam_selesai' => $jam->copy()
                        ->addMinutes($templateJadwal->durasi_ishoma)
                        ->format('H:i'),
                    'jenis' => 'ishoma',
                    'urutan' => $urutan++,
                ]);

                $jam->addMinutes(
                    $templateJadwal->durasi_ishoma
                );
            }
        }

        return back()->with(
            'success',
            'Template berhasil digenerate.'
        );
    }

    public function show(TemplateJadwal $templateJadwal)
    {
        $templateJadwal->load('jamPelajaran');

        return view(
            'template_jadwal.show',
            compact('templateJadwal')
        );
    }
}
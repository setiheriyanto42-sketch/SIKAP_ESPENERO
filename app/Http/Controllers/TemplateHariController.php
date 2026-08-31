<?php

namespace App\Http\Controllers;

use App\Models\TemplateHari;
use App\Models\TemplateJadwal;
use Illuminate\Http\Request;

class TemplateHariController extends Controller
{
    /**
     * Daftar hari yang digunakan sekolah.
     */
    private function daftarHari(): array
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
    }

    /**
     * Menampilkan pengaturan jam mulai setiap hari.
     */
    public function index(TemplateJadwal $templateJadwal)
    {
        $hari = $this->daftarHari();

        // Pastikan setiap hari sudah mempunyai data.
        foreach ($hari as $namaHari) {

            TemplateHari::firstOrCreate(
                [
                    'template_jadwal_id' => $templateJadwal->id,
                    'hari' => $namaHari,
                ],
                [
                    'jam_mulai' => '07:00',
                    'aktif' => true,
                ]
            );
        }

        // Ambil ulang data setelah proses firstOrCreate.
        $templateJadwal->load([
            'templateHaris' => function ($query) {
                $query->orderByRaw("
                    FIELD(
                        hari,
                        'Senin',
                        'Selasa',
                        'Rabu',
                        'Kamis',
                        'Jumat',
                        'Sabtu'
                    )
                ");
            }
        ]);

        return view(
            'template_jadwal.hari',
            compact('templateJadwal', 'hari')
        );
    }

    /**
     * Menyimpan pengaturan jam mulai setiap hari.
     */
    public function update(
        Request $request,
        TemplateJadwal $templateJadwal
    ) {
        $request->validate([
            'hari' => [
                'required',
                'array',
            ],

            'jam_mulai' => [
                'required',
                'array',
            ],

            'jam_mulai.*' => [
                'required',
                'date_format:H:i',
            ],
        ]);

        $hari = $request->hari;
        $jamMulai = $request->jam_mulai;

        foreach ($hari as $index => $namaHari) {

            TemplateHari::updateOrCreate(
                [
                    'template_jadwal_id' => $templateJadwal->id,
                    'hari' => $namaHari,
                ],
                [
                    'jam_mulai' => $jamMulai[$index] ?? '07:00',
                    'aktif' => isset($request->aktif[$index]),
                ]
            );
        }

        return back()->with(
            'success',
            'Pengaturan jam mulai setiap hari berhasil disimpan.'
        );
    }
}
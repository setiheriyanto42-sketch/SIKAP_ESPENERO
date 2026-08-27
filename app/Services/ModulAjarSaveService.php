<?php

namespace App\Services;

use App\Models\ModulAjar;
use App\Models\ModulBab;
use App\Models\ModulPertemuan;
use Illuminate\Support\Facades\DB;

class ModulAjarSaveService
{
    public function simpan(array $struktur)
    {
        DB::beginTransaction();

        try {

            $modul = ModulAjar::create([

                'nama_file' => $struktur['nama_file'] ?? null,

                'mata_pelajaran' => $struktur['mata_pelajaran'],

                'kelas' => $struktur['kelas'],

                'fase' => $struktur['fase'],

                'semester' => $struktur['semester'],

                'tahun_ajaran' => $struktur['tahun_ajaran'],

                'alokasi_waktu' => $struktur['alokasi_waktu'],

            ]);

            foreach ($struktur['bab'] as $bab) {

                $dbBab = ModulBab::create([

                    'modul_ajar_id' => $modul->id,

                    'nomor' => $bab['nomor'],

                    'judul' => $bab['judul'],

                    'isi' => $bab['isi'] ?? null,

                ]);

                foreach ($bab['pertemuan'] as $pertemuan) {

                    ModulPertemuan::create([

                        'modul_bab_id' => $dbBab->id,

                        'nomor' => $pertemuan['nomor'],

                        'tujuan' => $pertemuan['tujuan'] ?? null,

                        'materi' => $pertemuan['materi'] ?? null,

                        'aktivitas' => $pertemuan['aktivitas'] ?? null,

                        'asesmen' => $pertemuan['asesmen'] ?? null,

                    ]);
                }
            }

            DB::commit();

            return $modul;

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
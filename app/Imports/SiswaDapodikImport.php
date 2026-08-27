<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SiswaDapodikImport
{
    public function run(string $path): array
    {
        $sheet = IOFactory::load($path)
            ->getActiveSheet()
            ->toArray(null, true, true, true);

        /*
        |--------------------------------------------------------------------------
        | DATA MULAI BARIS KE-8
        |--------------------------------------------------------------------------
        */

        $rows = collect(array_slice($sheet, 7))
            ->filter(fn ($r) => !empty(trim($r['B'] ?? '')))
            ->map(function ($r) {

                $rombelDapodik = strtoupper(trim($r['AQ'] ?? ''));

                /*
                |--------------------------------------------------------------------------
                | NORMALISASI ROMBEL DAPODIK
                |
                | VII A  -> tingkat 7, rombel A
                | VIII B -> tingkat 8, rombel B
                | IX C   -> tingkat 9, rombel C
                |--------------------------------------------------------------------------
                */

                $tingkat = match (true) {

                    str_starts_with($rombelDapodik, 'VIII') => 8,

                    str_starts_with($rombelDapodik, 'VII') => 7,

                    str_starts_with($rombelDapodik, 'IX') => 9,

                    default => null,
                };

                /*
                |--------------------------------------------------------------------------
                | AMBIL KODE ROMBEL
                |--------------------------------------------------------------------------
                */

                $kodeRombel = match (true) {

                    str_starts_with($rombelDapodik, 'VIII')
                        => trim(substr($rombelDapodik, 4)),

                    str_starts_with($rombelDapodik, 'VII')
                        => trim(substr($rombelDapodik, 3)),

                    str_starts_with($rombelDapodik, 'IX')
                        => trim(substr($rombelDapodik, 2)),

                    default => null,
                };

                return [

                    'nama' => trim($r['B'] ?? ''),

                    'nis' => trim($r['C'] ?? ''),

                    'jk' => trim($r['D'] ?? ''),

                    'nisn' => trim($r['E'] ?? ''),

                    'tanggal_lahir' => $r['G'] ?? null,

                    'nik' => trim($r['H'] ?? ''),

                    'no_hp' => trim($r['T'] ?? ''),

                    'email' => trim($r['U'] ?? ''),

                    /*
                    | Data asli Dapodik
                    */
                    'rombel_dapodik' => $rombelDapodik,

                    /*
                    | Hasil normalisasi
                    */
                    'tingkat' => $tingkat,

                    'rombel' => $kodeRombel,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | HASIL IMPORT
        |--------------------------------------------------------------------------
        */

        $hasil = [

            'total_excel' => $rows->count(),

            'siswa_dibuat' => 0,

            'siswa_diperbarui' => 0,

            'kelas_dibuat' => 0,

            'kelas_diperbarui' => 0,

            'siswa_tidak_valid' => [],
        ];

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($rows, &$hasil) {

            /*
            |--------------------------------------------------------------------------
            | 1. PASTIKAN SEMUA KELAS ADA
            |--------------------------------------------------------------------------
            */

            $kelasList = $rows

                ->filter(fn ($row) =>
                    !empty($row['tingkat']) &&
                    !empty($row['rombel'])
                )

                ->map(fn ($row) => [

                    'tingkat' => $row['tingkat'],

                    'rombel' => $row['rombel'],

                    'nama_kelas' => $row['rombel_dapodik'],
                ])

                ->unique(fn ($row) =>
                    $row['tingkat'] . '-' . $row['rombel']
                )

                ->values();

            foreach ($kelasList as $dataKelas) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE ATAU BUAT KELAS
                |--------------------------------------------------------------------------
                */

                $kelas = Kelas::updateOrCreate(

                    [
                        'nama_kelas' => $dataKelas['nama_kelas'],
                    ],

                    [
                        'tingkat' => $dataKelas['tingkat'],

                        'rombel' => $dataKelas['rombel'],

                        'guru_id' => null,

                        'wali_kelas' => null,

                        'aktif' => true,
                    ]
                );

                if ($kelas->wasRecentlyCreated) {

                    $hasil['kelas_dibuat']++;

                } else {

                    $hasil['kelas_diperbarui']++;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 2. IMPORT SISWA
            |--------------------------------------------------------------------------
            */

            foreach ($rows as $data) {

                /*
                |--------------------------------------------------------------------------
                | VALIDASI DATA WAJIB
                |--------------------------------------------------------------------------
                */

                if (
                    empty($data['nama']) ||
                    empty($data['nisn']) ||
                    empty($data['tingkat']) ||
                    empty($data['rombel'])
                ) {

                    $hasil['siswa_tidak_valid'][] = [

                        'nama' => $data['nama'],

                        'nisn' => $data['nisn'],

                        'rombel' => $data['rombel_dapodik'],

                        'alasan' =>
                            'Nama, NISN, tingkat, atau rombel kosong',
                    ];

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | CARI KELAS
                |--------------------------------------------------------------------------
                */

                $kelas = Kelas::where('tingkat', $data['tingkat'])

                    ->where('rombel', $data['rombel'])

                    ->first();

                if (!$kelas) {

                    $hasil['siswa_tidak_valid'][] = [

                        'nama' => $data['nama'],

                        'nisn' => $data['nisn'],

                        'rombel' => $data['rombel_dapodik'],

                        'alasan' => 'Kelas tidak ditemukan',
                    ];

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | NISN SEBAGAI IDENTITAS UTAMA SINKRONISASI
                |--------------------------------------------------------------------------
                */

                $siswa = Siswa::where(
                    'nisn',
                    $data['nisn']
                )->first();

                /*
                |--------------------------------------------------------------------------
                | DATA SISWA
                |--------------------------------------------------------------------------
                */

                $payload = [

                    'nis' => $data['nis'] ?: null,

                    'nisn' => $data['nisn'],

                    'nama' => $data['nama'],

                    'jenis_kelamin' => $data['jk'] ?: null,

                    'tanggal_lahir' =>
                        $data['tanggal_lahir'] ?: null,

                    'nik' => $data['nik'] ?: null,

                    'no_hp' => $data['no_hp'] ?: null,

                    'email' => $data['email'] ?: null,

                    /*
                    |--------------------------------------------------------------------------
                    | STRUKTUR DATABASE SIKAP ESPENERO
                    |--------------------------------------------------------------------------
                    */

                    'kelas' => $data['tingkat'],

                    'rombel' => $data['rombel'],

                    'aktif' => true,

                    'updated_at' => now(),
                ];

                /*
                |--------------------------------------------------------------------------
                | UPDATE SISWA LAMA
                |--------------------------------------------------------------------------
                */

                if ($siswa) {

                    $siswa->update($payload);

                    $hasil['siswa_diperbarui']++;

                }

                /*
                |--------------------------------------------------------------------------
                | BUAT SISWA BARU
                |--------------------------------------------------------------------------
                */

                else {

                    $payload['created_at'] = now();

                    Siswa::create($payload);

                    $hasil['siswa_dibuat']++;
                }
            }
        });

        return $hasil;
    }
}
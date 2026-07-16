<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ==========================================
        // Lewati jika baris kosong
        // ==========================================

        if (
            empty($row['nis']) &&
            empty($row['nisn']) &&
            empty($row['nama'])
        ) {
            return null;
        }

        // ==========================================
        // Normalisasi Jenis Kelamin
        // ==========================================

        $jk = strtoupper(trim($row['jenis_kelamin'] ?? ''));

        if (in_array($jk, ['L', 'LAKI-LAKI', 'LAKI LAKI'])) {
            $jk = 'L';
        } elseif (in_array($jk, ['P', 'PEREMPUAN'])) {
            $jk = 'P';
        }

        // ==========================================
        // Skip jika NIS sudah ada
        // ==========================================

        if (Siswa::where('nis', $row['nis'])->exists()) {
            return null;
        }

        // ==========================================
        // Skip jika NISN sudah ada
        // ==========================================

        if (Siswa::where('nisn', $row['nisn'])->exists()) {
            return null;
        }

        // ==========================================
        // Skip jika nama kosong
        // ==========================================

        if (empty($row['nama'])) {
            return null;
        }

        // ==========================================
        // Pecah kelas dan rombel
        // Contoh:
        // 7A -> kelas=7 rombel=A
        // 8C -> kelas=8 rombel=C
        // ==========================================

        $kelasExcel = strtoupper(trim($row['kelas'] ?? ''));

        $kelas = (int) substr($kelasExcel, 0, 1);

        $rombel = substr($kelasExcel, 1);

        // ==========================================
        // Simpan ke database
        // ==========================================

        return new Siswa([

            'nis'             => trim($row['nis']),
            'nisn'            => trim($row['nisn']),
            'nama'            => trim($row['nama']),
            'jenis_kelamin'   => $jk,

            'kelas'           => $kelas,
            'rombel'          => $rombel,

            'no_hp'           => trim($row['no_hp'] ?? ''),
            'alamat'          => trim($row['alamat'] ?? ''),

            'aktif'           => true,

        ]);
    }
}

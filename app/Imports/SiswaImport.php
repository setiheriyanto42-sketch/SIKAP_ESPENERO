<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // =====================================================
        // 1. Lewati baris yang benar-benar kosong
        // =====================================================

        if (
            empty($row['nis']) &&
            empty($row['nisn']) &&
            empty($row['nama'])
        ) {
            return null;
        }

        // =====================================================
        // 2. Ambil dan bersihkan data dasar
        // =====================================================

        $nis  = trim((string) ($row['nis'] ?? ''));
        $nisn = trim((string) ($row['nisn'] ?? ''));
        $nama = trim((string) ($row['nama'] ?? ''));

        // =====================================================
        // 3. Nama wajib ada
        // =====================================================

        if ($nama === '') {
            return null;
        }

        // =====================================================
        // 4. NIS dan NISN harus tersedia
        // =====================================================

        if ($nis === '' || $nisn === '') {
            return null;
        }

        // =====================================================
        // 5. Normalisasi Jenis Kelamin
        // =====================================================

        $jk = strtoupper(
            trim((string) ($row['jenis_kelamin'] ?? ''))
        );

        if (
            in_array($jk, [
                'L',
                'LAKI-LAKI',
                'LAKI LAKI',
                'LAKI'
            ])
        ) {
            $jk = 'L';

        } elseif (
            in_array($jk, [
                'P',
                'PEREMPUAN'
            ])
        ) {
            $jk = 'P';

        } else {
            $jk = null;
        }

        // =====================================================
        // 6. Jangan memasukkan NIS yang sudah ada
        // =====================================================

        if (
            Siswa::where('nis', $nis)->exists()
        ) {
            return null;
        }

        // =====================================================
        // 7. Jangan memasukkan NISN yang sudah ada
        // =====================================================

        if (
            Siswa::where('nisn', $nisn)->exists()
        ) {
            return null;
        }

        // =====================================================
        // 8. Baca Kelas + Rombel
        //
        // Contoh:
        // 7A
        // 7 A
        // 8B
        // 9F
        // =====================================================

        $kelasExcel = strtoupper(
            trim((string) ($row['kelas'] ?? ''))
        );

        $kelasExcel = str_replace(
            [' ', '-', '_'],
            '',
            $kelasExcel
        );

        $kelas = null;
        $rombel = null;

        // Bentuk 7A / 8B / 9F
        if (preg_match('/^([789])([A-F])$/', $kelasExcel, $match)) {

            $kelas = (int) $match[1];
            $rombel = $match[2];

        } else {

            // =================================================
            // Jika format kelas tidak dikenali
            // jangan memasukkan data secara sembarangan
            // =================================================

            return null;
        }

        // =====================================================
        // 9. Data tambahan
        // =====================================================

        $tempatLahir = trim(
            (string) ($row['tempat_lahir'] ?? '')
        );

        $tanggalLahir = $row['tanggal_lahir'] ?? null;

        $agama = trim(
            (string) ($row['agama'] ?? '')
        );

        $alamat = trim(
            (string) ($row['alamat'] ?? '')
        );

        $namaAyah = trim(
            (string) ($row['nama_ayah'] ?? '')
        );

        $namaIbu = trim(
            (string) ($row['nama_ibu'] ?? '')
        );

        $nik = trim(
            (string) ($row['nik'] ?? '')
        );

        $noHp = trim(
            (string) ($row['no_hp'] ?? '')
        );

        $email = trim(
            (string) ($row['email'] ?? '')
        );

        // =====================================================
        // 10. Simpan siswa baru
        // =====================================================

        return new Siswa([

            'nis'             => $nis,
            'nisn'            => $nisn,
            'nama'            => $nama,
            'jenis_kelamin'   => $jk,

            'tempat_lahir'    => $tempatLahir,
            'tanggal_lahir'   => $tanggalLahir,
            'agama'           => $agama,

            'alamat'          => $alamat,

            'nama_ayah'       => $namaAyah,
            'nama_ibu'        => $namaIbu,

            'nik'             => $nik,
            'no_hp'           => $noHp,
            'email'           => $email,

            'kelas'           => $kelas,
            'rombel'          => $rombel,

            'aktif'           => true,

        ]);
    }
}
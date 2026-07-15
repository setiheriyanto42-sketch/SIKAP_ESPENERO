<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $jk = strtoupper(trim($row['jenis_kelamin']));

        if ($jk == 'LAKI-LAKI' || $jk == 'L') {
            $jk = 'L';
        } elseif ($jk == 'PEREMPUAN' || $jk == 'P') {
            $jk = 'P';
        }

        return new Siswa([

            'nis'             => $row['nis'],
            'nisn'            => $row['nisn'],
            'nama'            => $row['nama'],
            'jenis_kelamin'   => $jk,

            'kelas'           => $row['kelas'],

            'no_hp'           => $row['no_hp'],

            'alamat'          => $row['alamat'],

            'aktif'           => true,

        ]);
    }
}

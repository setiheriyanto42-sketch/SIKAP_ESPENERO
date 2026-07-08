<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $jk = strtoupper(trim($row['jenis_kelamin']));

        if ($jk == 'LAKI-LAKI' || $jk == 'L') {
            $jk = 'L';
        } elseif ($jk == 'PEREMPUAN' || $jk == 'P') {
            $jk = 'P';
        }

        return new Guru([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'jenis_kelamin' => $jk,
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'alamat' => $row['alamat'],
            'aktif' => true,
        ]);
    }
}

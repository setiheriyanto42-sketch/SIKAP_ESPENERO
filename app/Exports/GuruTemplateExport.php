<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class GuruTemplateExport implements FromArray
{
    public function array(): array
    {
        return [

            [
                'NIP',
                'Nama',
                'Jenis Kelamin',
                'No HP',
                'Email',
                'Alamat',
            ],

            [
                '198712042024011001',
                'Budi Santoso',
                'L',
                '08123456789',
                'budi@gmail.com',
                'Wonogiri',
            ],

            [
                '198901012024011002',
                'Siti Aminah',
                'P',
                '08123456788',
                'siti@gmail.com',
                'Jatiroto',
            ],

        ];
    }
}

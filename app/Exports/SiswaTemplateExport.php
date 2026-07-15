<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaTemplateExport implements FromCollection
{
    public function collection()
    {
        return new Collection([

            [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Kelas',
                'No HP',
                'Alamat'
            ],

            [
                '24001',
                '00987654321',
                'Andi Saputra',
                'L',
                '7A',
                '081234567890',
                'Jatiroto'
            ],

            [
                '24002',
                '00987654322',
                'Siti Rahma',
                'P',
                '7A',
                '081234567891',
                'Wonogiri'
            ],

        ]);
    }
}

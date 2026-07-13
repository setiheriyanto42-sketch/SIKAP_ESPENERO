<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->truncate();

        DB::table('roles')->insert([

            [
                'id' => 1,
                'nama_role' => 'Admin',
                'keterangan' => 'Administrator Sistem',
            ],

            [
                'id' => 2,
                'nama_role' => 'Guru',
                'keterangan' => 'Guru Mata Pelajaran',
            ],

            [
                'id' => 3,
                'nama_role' => 'Wali Kelas',
                'keterangan' => 'Wali Kelas',
            ],

            [
                'id' => 4,
                'nama_role' => 'BK',
                'keterangan' => 'Guru BK',
            ],

            [
                'id' => 5,
                'nama_role' => 'Kepala Sekolah',
                'keterangan' => 'Monitoring',
            ],

        ]);
    }
}

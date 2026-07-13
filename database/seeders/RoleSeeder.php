<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->delete();

        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1;');

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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

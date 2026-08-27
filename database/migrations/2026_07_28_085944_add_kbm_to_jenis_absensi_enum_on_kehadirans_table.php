<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE kehadirans
            MODIFY jenis_absensi
            ENUM('Harian','Mapel','Kegiatan','KBM')
            NOT NULL DEFAULT 'Harian'
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE kehadirans
            SET jenis_absensi = 'Harian'
            WHERE jenis_absensi = 'KBM'
        ");

        DB::statement("
            ALTER TABLE kehadirans
            MODIFY jenis_absensi
            ENUM('Harian','Mapel','Kegiatan')
            NOT NULL DEFAULT 'Harian'
        ");
    }
};
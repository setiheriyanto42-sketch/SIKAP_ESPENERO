<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {

            // Jenis absensi
            $table->enum('jenis_absensi', [
                'Harian',
                'Mapel',
                'Kegiatan'
            ])->default('Harian')->after('kelas_id');

            // Mata pelajaran (khusus guru mapel)
            $table->foreignId('mapel_id')
                  ->nullable()
                  ->after('jenis_absensi')
                  ->constrained('mata_pelajarans')
                  ->nullOnDelete();

            // Kegiatan sekolah
            $table->string('kegiatan')
                  ->nullable()
                  ->after('mapel_id');

            // Status Membolos
            $table->enum('status', [
                'Hadir',
                'Izin',
                'Sakit',
                'Alfa',
                'Membolos',
                'Terlambat'
            ])->default('Hadir')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {

            $table->dropForeign(['mapel_id']);

            $table->dropColumn([
                'jenis_absensi',
                'mapel_id',
                'kegiatan'
            ]);

        });
    }
};

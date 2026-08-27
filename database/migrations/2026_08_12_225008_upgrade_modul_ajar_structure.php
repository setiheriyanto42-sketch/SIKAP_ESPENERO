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
        Schema::table('modul_ajars', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | JANGAN TAMBAHKAN guru_id
            |--------------------------------------------------------------------------
            | Kolom guru_id sudah ada di database.
            */

            if (!Schema::hasColumn('modul_ajars', 'judul')) {
                $table->string('judul')
                    ->nullable()
                    ->after('nama_file');
            }

            if (!Schema::hasColumn('modul_ajars', 'keterangan')) {
                $table->text('keterangan')
                    ->nullable()
                    ->after('judul');
            }

            if (!Schema::hasColumn('modul_ajars', 'aktif')) {
                $table->boolean('aktif')
                    ->default(true)
                    ->after('tahun_ajaran');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modul_ajars', function (Blueprint $table) {

            if (Schema::hasColumn('modul_ajars', 'aktif')) {
                $table->dropColumn('aktif');
            }

            if (Schema::hasColumn('modul_ajars', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            if (Schema::hasColumn('modul_ajars', 'judul')) {
                $table->dropColumn('judul');
            }

            /*
            |--------------------------------------------------------------------------
            | guru_id TIDAK DIHAPUS
            |--------------------------------------------------------------------------
            | Karena kolom ini sudah ada sebelum migration ini dijalankan.
            */

        });
    }
};
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
        Schema::table('modul_pertemuans', function (Blueprint $table) {

            $table->date('tanggal')
                ->nullable()
                ->after('nomor');

            $table->string('jenis')
                ->default('rencana')
                ->after('tanggal');

            $table->text('catatan')
                ->nullable()
                ->after('asesmen');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modul_pertemuans', function (Blueprint $table) {

            $table->dropColumn([
                'tanggal',
                'jenis',
                'catatan',
            ]);

        });
    }
};

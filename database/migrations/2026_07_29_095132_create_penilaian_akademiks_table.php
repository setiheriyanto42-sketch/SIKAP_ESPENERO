<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_akademiks', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | SUMBER PENILAIAN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('sesi_mengajar_id')
                ->constrained('sesi_mengajars')
                ->cascadeOnDelete();

            $table->foreignId('perencanaan_pertemuan_id')
                ->nullable()
                ->constrained('perencanaan_pertemuans')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS PENILAIAN
            |--------------------------------------------------------------------------
            */

            $table->enum('jenis', [
                'Tugas',
                'UH',
                'Praktik',
                'Proyek'
            ]);

            $table->string('judul');

            $table->date('tanggal')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_akademiks');
    }
};
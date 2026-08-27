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
        Schema::create('modul_ajars', function (Blueprint $table) {

            $table->id();

            $table->string('nama_file')->nullable();

            $table->string('mata_pelajaran')->nullable();

            $table->string('kelas')->nullable();

            $table->string('fase')->nullable();

            $table->string('semester')->nullable();

            $table->string('tahun_ajaran')->nullable();

            $table->string('alokasi_waktu')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_ajars');
    }
};

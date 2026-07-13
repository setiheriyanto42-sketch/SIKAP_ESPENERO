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
        Schema::create('kehadirans', function (Blueprint $table) {

            $table->id();

            $table->date('tanggal');

            $table->foreignId('guru_id')->constrained('gurus');

            $table->foreignId('siswa_id')->constrained('siswas');

            $table->unsignedBigInteger('kelas_id');

            $table->string('mata_pelajaran');

            $table->enum('status', [
                'Hadir',
                'Izin',
                'Sakit',
                'Alfa',
                'Terlambat'
            ])->default('Hadir');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};

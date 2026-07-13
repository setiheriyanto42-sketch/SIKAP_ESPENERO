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
        Schema::create('guru_mengajars', function (Blueprint $table) {

            $table->id();

            // Guru
            $table->foreignId('guru_id')
                ->constrained('gurus')
                ->cascadeOnDelete();

            // Mata Pelajaran
            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->cascadeOnDelete();

            // Kelas
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            // Tahun ajaran
            $table->string('tahun_ajaran',20);

            // Semester
            $table->enum('semester',[
                'Ganjil',
                'Genap'
            ]);

            // Status aktif
            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mengajars');
    }
};

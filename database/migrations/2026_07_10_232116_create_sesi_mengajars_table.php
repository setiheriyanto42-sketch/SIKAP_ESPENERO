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
        Schema::create('sesi_mengajars', function (Blueprint $table) {

            $table->id();

            $table->foreignId('guru_mengajar_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('jadwal_mengajar_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->timestamp('jam_mulai')->nullable();

            $table->timestamp('jam_selesai')->nullable();

            $table->enum('status', [
                'Belum',
                'Sedang',
                'Selesai'
            ])->default('Belum');

            $table->timestamps();

            // Satu jadwal hanya boleh memiliki satu sesi per tanggal
            $table->unique([
                'jadwal_mengajar_id',
                'tanggal'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_mengajars');
    }
};

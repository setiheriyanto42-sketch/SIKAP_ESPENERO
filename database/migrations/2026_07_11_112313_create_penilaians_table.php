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
        Schema::create('penilaians', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sesi_mengajar_id')->constrained()->cascadeOnDelete();

            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

            $table->decimal('nilai_tugas',5,2)->nullable();

            $table->decimal('nilai_uts',5,2)->nullable();

            $table->decimal('nilai_uas',5,2)->nullable();

            $table->decimal('nilai_akhir',5,2)->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};

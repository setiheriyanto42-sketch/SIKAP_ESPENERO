<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sesi_mengajar_id')->constrained()->cascadeOnDelete();

            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

            $table->enum('predikat',[
                'Sangat Baik',
                'Baik',
                'Cukup',
                'Perlu Pembinaan'
            ]);

            $table->text('catatan')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};

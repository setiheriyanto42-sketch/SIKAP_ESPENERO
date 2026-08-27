<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_akademik_details', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | PENILAIAN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('penilaian_akademik_id')
                ->constrained('penilaian_akademiks')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | SISWA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | NILAI
            |--------------------------------------------------------------------------
            */

            $table->decimal('nilai', 5, 2)->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | CEGAH SISWA GANDA
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'penilaian_akademik_id',
                'siswa_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_akademik_details');
    }
};
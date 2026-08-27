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
        Schema::create('modul_pertemuans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('modul_bab_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('nomor');

            $table->text('tujuan')->nullable();

            $table->longText('materi')->nullable();

            $table->longText('aktivitas')->nullable();

            $table->longText('asesmen')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_pertemuans');
    }
};

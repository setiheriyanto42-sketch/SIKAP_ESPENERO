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
        Schema::create('perencanaan_babs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('perencanaan_pembelajaran_id')
                ->constrained('perencanaan_pembelajarans')
                ->cascadeOnDelete();

            $table->string('nama_bab');

            $table->text('tujuan')->nullable();

            $table->integer('jumlah_pertemuan');

            $table->integer('urutan');

            $table->boolean('aktif')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaan_babs');
    }
};

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
        Schema::create('perencanaan_pertemuans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('perencanaan_bab_id')
                ->constrained('perencanaan_babs')
                ->cascadeOnDelete();

            $table->integer('pertemuan_ke');

            $table->string('judul');

            $table->longText('materi')->nullable();

            $table->boolean('sudah_diajarkan')->default(false);

            $table->boolean('ada_penilaian')->default(false);

            $table->date('tanggal')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaan_pertemuans');
    }
};

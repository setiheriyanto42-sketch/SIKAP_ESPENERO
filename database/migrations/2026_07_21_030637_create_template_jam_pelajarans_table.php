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
        Schema::create('template_jam_pelajarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_jadwal_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('template_hari_id')
                ->nullable()
                ->constrained('template_haris')
                ->cascadeOnDelete();

            $table->string('nama_template'); // Reguler, Ramadhan, Ujian, ANBK

            $table->unsignedTinyInteger('jp')->nullable();

            $table->unsignedTinyInteger('jam_ke')->nullable();

            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->enum('jenis', [
                'sambut_pagi',
                'pembiasaan_pagi',
                'belajar',
                'istirahat_1',
                'istirahat_2',
                'ishoma',
                'upacara',
                'senam',
                'kegiatan',
                'pulang'
            ])->default('belajar');

            $table->boolean('aktif')->default(false);

            $table->integer('urutan')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_jam_pelajarans');
    }
};

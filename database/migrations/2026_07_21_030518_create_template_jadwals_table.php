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
        Schema::create('template_jadwals', function (Blueprint $table) {

            $table->id();

            $table->string('nama');

            $table->integer('durasi_jp')->default(40);

            $table->time('jam_masuk');

            $table->integer('jumlah_jp')->default(10);

            $table->integer('istirahat_setelah')->nullable();

            $table->integer('durasi_istirahat')->default(20);

            $table->integer('ishoma_setelah')->nullable();

            $table->integer('durasi_ishoma')->default(40);

            $table->boolean('aktif')->default(false);

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_jadwals');
    }
};

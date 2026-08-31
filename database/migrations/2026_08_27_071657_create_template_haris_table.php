<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_haris', function (Blueprint $table) {

            $table->id();

            $table->string('hari');

            $table->time('jam_mulai_jp1');

            $table->boolean('aktif')->default(true);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique('hari');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_haris');
    }
};
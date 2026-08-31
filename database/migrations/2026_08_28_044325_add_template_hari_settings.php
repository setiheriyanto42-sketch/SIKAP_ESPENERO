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

            $table->foreignId('template_jadwal_id')
                ->constrained('template_jadwals')
                ->cascadeOnDelete();

            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ]);

            $table->time('jam_mulai');

            $table->boolean('aktif')->default(true);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique([
                'template_jadwal_id',
                'hari'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('template_jadwals', function (Blueprint $table) {
            $table->time('jam_masuk')->nullable(false)->change();
        });
    }
};
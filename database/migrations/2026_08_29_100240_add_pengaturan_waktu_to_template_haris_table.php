<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_haris', function (Blueprint $table) {

            // Override aturan istirahat per hari
            $table->unsignedTinyInteger('istirahat_setelah')
                ->nullable()
                ->after('jam_mulai');

            $table->unsignedSmallInteger('durasi_istirahat')
                ->nullable()
                ->after('istirahat_setelah');

            // Override aturan Ishoma per hari
            $table->unsignedTinyInteger('ishoma_setelah')
                ->nullable()
                ->after('durasi_istirahat');

            $table->unsignedSmallInteger('durasi_ishoma')
                ->nullable()
                ->after('ishoma_setelah');
        });
    }

    public function down(): void
    {
        Schema::table('template_haris', function (Blueprint $table) {

            $table->dropColumn([
                'istirahat_setelah',
                'durasi_istirahat',
                'ishoma_setelah',
                'durasi_ishoma',
            ]);
        });
    }
};
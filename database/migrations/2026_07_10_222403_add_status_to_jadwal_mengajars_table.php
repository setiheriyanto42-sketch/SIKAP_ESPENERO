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
        Schema::table('jadwal_mengajars', function (Blueprint $table) {

            $table->enum('status', [
                'Belum',
                'Sedang',
                'Selesai'
            ])->default('Belum')->after('aktif');

            $table->timestamp('waktu_mulai')->nullable()->after('status');

            $table->timestamp('waktu_selesai')->nullable()->after('waktu_mulai');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_mengajars', function (Blueprint $table) {

            $table->dropColumn([
                'status',
                'waktu_mulai',
                'waktu_selesai'
            ]);

        });
    }
};

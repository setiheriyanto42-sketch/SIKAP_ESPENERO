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
        Schema::table('kehadirans', function (Blueprint $table) {

            $table->foreignId('sesi_mengajar_id')
                ->nullable()
                ->after('id')
                ->constrained('sesi_mengajars')
                ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {

            $table->dropForeign(['sesi_mengajar_id']);

            $table->dropColumn('sesi_mengajar_id');

        });
    }
};

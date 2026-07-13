<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->foreignId('sesi_mengajar_id')
                  ->after('id')
                  ->constrained()
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->dropForeign(['sesi_mengajar_id']);

            $table->dropColumn('sesi_mengajar_id');

        });
    }
};

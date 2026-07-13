<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru_mengajars', function (Blueprint $table) {

            $table->foreignId('tahun_ajaran_id')
                  ->after('id')
                  ->constrained('tahun_ajarans')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('guru_mengajars', function (Blueprint $table) {

            $table->dropForeign(['tahun_ajaran_id']);

            $table->dropColumn('tahun_ajaran_id');

        });
    }
};

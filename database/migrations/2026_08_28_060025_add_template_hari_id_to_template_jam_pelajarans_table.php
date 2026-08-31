<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_jam_pelajarans', function (Blueprint $table) {

            $table->foreignId('template_hari_id')
                ->nullable()
                ->after('template_jadwal_id')
                ->constrained('template_haris')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('template_jam_pelajarans', function (Blueprint $table) {

            $table->dropForeign([
                'template_hari_id'
            ]);

            $table->dropColumn('template_hari_id');

        });
    }
};
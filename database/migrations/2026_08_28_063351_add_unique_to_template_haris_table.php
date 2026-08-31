<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_haris', function (Blueprint $table) {
            $table->unique(
                ['template_jadwal_id', 'hari'],
                'template_hari_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('template_haris', function (Blueprint $table) {
            $table->dropUnique('template_hari_unique');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->unsignedTinyInteger('tingkat')->change();
            $table->string('rombel', 10)->change();
            $table->string('nama_kelas', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('rombel', 5)->change();
            $table->string('nama_kelas', 10)->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modul_ajars', function (Blueprint $table) {
            $table->unsignedTinyInteger('jp_per_pertemuan')
                ->default(1)
                ->after('alokasi_waktu');
        });
    }

    public function down(): void
    {
        Schema::table('modul_ajars', function (Blueprint $table) {
            $table->dropColumn('jp_per_pertemuan');
        });
    }
};
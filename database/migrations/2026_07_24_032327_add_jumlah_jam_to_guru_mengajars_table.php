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
        Schema::table('guru_mengajars', function (Blueprint $table) {

            $table->unsignedTinyInteger('jumlah_jam')
                ->default(1)
                ->after('mata_pelajaran_id');

        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_mengajars', function (Blueprint $table) {

            $table->dropColumn('jumlah_jam');

        });
    }
};

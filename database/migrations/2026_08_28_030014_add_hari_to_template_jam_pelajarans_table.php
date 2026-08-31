<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_jam_pelajarans', function (Blueprint $table) {

            $table->string('hari')
                ->after('template_jadwal_id')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('template_jam_pelajarans', function (Blueprint $table) {
        $table->string('hari', 20)
            ->nullable()
            ->after('nama_template');
            });
    }
};
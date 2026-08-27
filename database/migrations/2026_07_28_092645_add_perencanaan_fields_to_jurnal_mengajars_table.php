<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->foreignId('perencanaan_pertemuan_id')
                ->nullable()
                ->after('sesi_mengajar_id')
                ->constrained('perencanaan_pertemuans')
                ->nullOnDelete();

            $table->text('materi_tercapai')
                ->nullable()
                ->after('perencanaan_pertemuan_id');

            $table->text('refleksi')
                ->nullable()
                ->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->dropForeign([
                'perencanaan_pertemuan_id'
            ]);

            $table->dropColumn([
                'perencanaan_pertemuan_id',
                'materi_tercapai',
                'refleksi',
            ]);
        });
    }
};
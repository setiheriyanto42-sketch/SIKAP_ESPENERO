<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->text('materi')->nullable()
                ->after('sesi_mengajar_id');

            $table->text('tujuan')->nullable()
                ->after('materi');

            $table->text('catatan')->nullable()
                ->after('tujuan');

            $table->unsignedInteger('jumlah_hadir')
                ->default(0)
                ->after('catatan');

            $table->unsignedInteger('jumlah_tidak_hadir')
                ->default(0)
                ->after('jumlah_hadir');
        });
    }

    public function down(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {

            $table->dropColumn([
                'materi',
                'tujuan',
                'catatan',
                'jumlah_hadir',
                'jumlah_tidak_hadir',
            ]);
        });
    }
};
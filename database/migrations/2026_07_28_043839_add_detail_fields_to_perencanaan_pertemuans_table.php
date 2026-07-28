<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perencanaan_pertemuans', function (Blueprint $table) {

            $table->text('tujuan')->nullable()->after('materi');

            $table->string('metode')->nullable()->after('tujuan');

            $table->string('media')->nullable()->after('metode');

            $table->longText('lkpd')->nullable()->after('media');

            $table->longText('asesmen')->nullable()->after('lkpd');

            $table->longText('catatan')->nullable()->after('asesmen');

            $table->longText('refleksi')->nullable()->after('catatan');

        });
    }

    public function down(): void
    {
        Schema::table('perencanaan_pertemuans', function (Blueprint $table) {

            $table->dropColumn([

                'tujuan',
                'metode',
                'media',
                'lkpd',
                'asesmen',
                'catatan',
                'refleksi',

            ]);

        });
    }
};
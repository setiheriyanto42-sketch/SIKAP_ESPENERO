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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')
                  ->nullable()
                  ->after('id');

            $table->index('role_id');

            $table->boolean('aktif')
                  ->default(true)
                  ->after('password');

            $table->string('foto')
                  ->nullable()
                  ->after('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropIndex(['role_id']);
        $table->dropColumn([
            'role_id',
            'aktif',
            'foto'
        ]);
    });
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('guru_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('gurus')
                  ->nullOnDelete();

            $table->foreignId('role_id')
                  ->nullable()
                  ->after('guru_id')
                  ->constrained('roles')
                  ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['guru_id']);
            $table->dropForeign(['role_id']);

            $table->dropColumn('guru_id');
            $table->dropColumn('role_id');

        });
    }
};

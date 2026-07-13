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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique();

            $table->string('nama', 100);

            $table->enum('jenis_kelamin', ['L','P']);

            $table->string('tempat_lahir', 50)->nullable();

            $table->date('tanggal_lahir')->nullable();

            $table->string('agama',30)->nullable();

            $table->text('alamat')->nullable();

            $table->string('nama_ayah',100)->nullable();

            $table->string('nama_ibu',100)->nullable();

            $table->string('no_hp',20)->nullable();

            $table->string('foto')->nullable();

            $table->unsignedTinyInteger('kelas');

            $table->string('rombel',2);

            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};

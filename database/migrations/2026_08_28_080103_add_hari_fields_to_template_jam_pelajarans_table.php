<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom template_hari_id sudah ada di tabel.
        // Tidak perlu menambahkannya lagi.
    }

    public function down(): void
    {
        // Tidak melakukan apa-apa.
    }
};
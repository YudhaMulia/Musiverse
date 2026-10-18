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
        Schema::create('kartu_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('nomor')->unique();   // 1-32, sama dengan nomor di nama file gambar
            $table->string('slug')->unique();                 // misal jembatan-ampera
            $table->string('nama');                           // misal Jembatan Ampera
            $table->string('kategori');                       // misal Kuliner
            $table->text('penjelasan');                       // tampil di halaman rekap
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_matches');
    }
};

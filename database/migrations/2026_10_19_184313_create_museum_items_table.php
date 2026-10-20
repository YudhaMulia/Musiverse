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
    Schema::create('museum_items', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('slug')->unique();
        $table->string('kategori')->index();
        $table->text('deskripsi_singkat');
        $table->longText('deskripsi_lengkap')->nullable();
        $table->string('asal_daerah')->nullable();
        $table->text('image_url')->nullable();
        $table->boolean('is_featured')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('museum_items');
    }
};

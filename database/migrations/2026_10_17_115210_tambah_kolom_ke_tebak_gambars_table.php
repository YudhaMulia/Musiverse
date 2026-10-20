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
        Schema::table('tebak_gambars', function (Blueprint $table) {
            $table->string('gambar')->nullable()->unique()->after('id');   // nama file, misal jembatan-ampera.jpg
            $table->string('jawaban')->nullable()->after('gambar');        // misal Jembatan Ampera
            $table->text('penjelasan')->nullable()->after('jawaban');      // tampil di halaman rekap
        });
    }

    public function down(): void
    {
        Schema::table('tebak_gambars', function (Blueprint $table) {
            $table->dropUnique(['gambar']);
            $table->dropColumn(['gambar', 'jawaban', 'penjelasan']);
        });
    }
};

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
        Schema::table('cagar_budayas', function (Blueprint $table) {
            $table->string('local_image_path')->nullable()->after('image_url')->comment('Lokasi gambar upload lokal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cagar_budayas', function (Blueprint $table) {
            $table->dropColumn('local_image_path');
        });
    }
};

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
        Schema::dropIfExists('room_cards');
        Schema::dropIfExists('card_items');   // aman: kalau tabelnya tidak ada, tidak error
    }

    public function down(): void
    {
        Schema::create('room_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};

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
        Schema::create('audio_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cagar_budaya_id')->constrained('cagar_budayas')->onDelete('cascade');
            $table->string('title');
            $table->text('narration'); // AI-generated text
            $table->string('audio_file_url')->nullable(); // MP3 or WAV file
            $table->integer('duration_seconds')->nullable(); // Duration in seconds
            $table->string('narrator')->default('AI Heritage Lab'); // Who narrated
            $table->string('language')->default('id'); // Language code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_tours');
    }
};

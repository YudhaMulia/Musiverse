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
        Schema::create('cagar_budayas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('era_id')->constrained('eras')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->string('registration_number')->nullable(); // e.g., "CB-04/PLG/2018"
            $table->string('architect')->nullable();
            $table->integer('year_built')->nullable();
            $table->string('original_function')->nullable();
            $table->string('current_function')->nullable();
            $table->string('status')->default('active'); // active, maintenance, closed
            $table->text('image_url')->nullable();
            $table->text('ai_reconstruction_url')->nullable(); // AI-generated visual
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cagar_budayas');
    }
};

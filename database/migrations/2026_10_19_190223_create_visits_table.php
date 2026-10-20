<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('site_slug', 120);
            $table->text('story')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('frame', 20)->default('polaroid');
            $table->json('stickers')->nullable();
            $table->boolean('nearby')->default(false);
            $table->unsignedSmallInteger('points')->default(10);
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->unique(['user_id', 'site_slug']);
        });

        Schema::create('visit_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->cascadeOnDelete();
            $table->string('path');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_photos');
        Schema::dropIfExists('visits');
    }
};
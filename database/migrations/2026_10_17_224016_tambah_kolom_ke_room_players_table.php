<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_players', function (Blueprint $table) {
            $table->foreignId('room_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->after('room_id')->constrained()->cascadeOnDelete(); // kosong = bot
            $table->string('name', 60)->after('user_id');
            $table->unsignedTinyInteger('avatar')->default(1)->after('name');   // 1 sampai 10
            $table->boolean('is_bot')->default(false)->after('avatar');
            $table->boolean('is_host')->default(false)->after('is_bot');

            $table->unique(['room_id', 'user_id']);   // satu akun hanya sekali per ruangan
        });
    }

    public function down(): void
    {
        Schema::table('room_players', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['user_id']);
            $table->dropUnique(['room_id', 'user_id']);
            $table->dropColumn(['room_id', 'user_id', 'name', 'avatar', 'is_bot', 'is_host']);
        });
    }
};
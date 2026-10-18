<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('code', 6)->unique()->after('id');          // kode ruangan, misal BDY7K2
            $table->string('game', 10)->after('code');                 // match | quiz | puzzle
            $table->foreignId('host_id')->after('game')->constrained('users')->cascadeOnDelete();
            $table->string('status', 10)->default('waiting')->after('host_id'); // waiting | playing | finished
            $table->timestamp('started_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropForeign(['host_id']);
            $table->dropColumn(['code', 'game', 'host_id', 'status', 'started_at']);
        });
    }
};
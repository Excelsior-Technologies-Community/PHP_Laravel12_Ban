<?php
// database/migrations/2024_01_01_000001_create_ban_history_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ban_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('banned_by')->constrained('users');
            $table->foreignId('unbanned_by')->nullable()->constrained('users');
            $table->text('ban_reason');
            $table->text('unban_reason')->nullable();
            $table->timestamp('banned_at');
            $table->timestamp('unbanned_at')->nullable();
            $table->timestamp('ban_until')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ban_history');
    }
};
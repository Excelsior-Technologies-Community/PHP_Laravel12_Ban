<?php
// database/migrations/2024_01_01_000000_add_ban_columns_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false);
            $table->timestamp('banned_until')->nullable();
            $table->text('ban_reason')->nullable();
            $table->foreignId('banned_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_until', 'ban_reason', 'banned_by']);
        });
    }
};
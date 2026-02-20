<?php
// app/Console/Commands/CheckExpiredBans.php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckExpiredBans extends Command
{
    protected $signature = 'bans:check-expired';
    protected $description = 'Check and unban users with expired bans';

    public function handle()
    {
        User::where('is_banned', true)
            ->where('banned_until', '<', now())
            ->update([
                'is_banned' => false,
                'banned_until' => null,
            ]);

        $this->info('Expired bans have been cleared.');
    }
}
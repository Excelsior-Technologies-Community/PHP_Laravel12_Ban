<?php
// app/Services/BanService.php

namespace App\Services;

use App\Models\User;
use App\Models\BanHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BanService
{
    public function banUser(User $user, User $bannedBy, string $reason, $banUntil = null)
    {
        // Debug: Check if user has ID
        if (!$user || !$user->id) {
            throw new \Exception('User is not valid or has no ID');
        }

        return DB::transaction(function () use ($user, $bannedBy, $reason, $banUntil) {
            // Ban the user
            $user->update([
                'is_banned' => true,
                'banned_until' => $banUntil,
                'ban_reason' => $reason,
                'banned_by' => $bannedBy->id,
            ]);

            // Create ban history record
            $banHistory = BanHistory::create([
                'user_id' => $user->id,
                'banned_by' => $bannedBy->id,
                'ban_reason' => $reason,
                'banned_at' => now(),
                'ban_until' => $banUntil,
            ]);

            // Check if ban history was created
            if (!$banHistory) {
                throw new \Exception('Failed to create ban history record');
            }

            return $user;
        });
    }

    public function unbanUser(User $user, User $unbannedBy, ?string $reason = null)
    {
        return DB::transaction(function () use ($user, $unbannedBy, $reason) {
            $user->update([
                'is_banned' => false,
                'banned_until' => null,
                'ban_reason' => null,
                'banned_by' => null,
            ]);

            $banHistory = BanHistory::where('user_id', $user->id)
                ->whereNull('unbanned_at')
                ->latest()
                ->first();

            if ($banHistory) {
                $banHistory->update([
                    'unbanned_by' => $unbannedBy->id,
                    'unban_reason' => $reason,
                    'unbanned_at' => now(),
                ]);
            }

            return $user;
        });
    }

    public function getBannedUsers()
    {
        return User::where('is_banned', true)
            ->with(['bannedBy', 'banHistory'])
            ->paginate(15);
    }

    public function getBanHistory(User $user)
    {
        return $user->banHistory()
            ->with(['bannedBy', 'unbannedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
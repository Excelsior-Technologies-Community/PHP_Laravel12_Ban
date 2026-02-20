<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_banned',
        'banned_until',
        'ban_reason',
        'banned_by',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_until' => 'datetime',
        'is_banned' => 'boolean',
    ];

    // Relationships
    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function banHistory()
    {
        return $this->hasMany(BanHistory::class);
    }

    // Check if user is banned
    public function isBanned()
    {
        if (!$this->is_banned) {
            return false;
        }

        if ($this->banned_until && $this->banned_until->isPast()) {
            $this->update(['is_banned' => false, 'banned_until' => null]);
            return false;
        }

        return true;
    }
}
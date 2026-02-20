<?php
// app/Models/BanHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanHistory extends Model
{
    use HasFactory;

    protected $table = 'ban_history';

    protected $fillable = [
        'user_id',
        'banned_by',
        'unbanned_by',
        'ban_reason',
        'unban_reason',
        'banned_at',
        'unbanned_at',
        'ban_until',
    ];

    protected $casts = [
        'banned_at' => 'datetime',
        'unbanned_at' => 'datetime',
        'ban_until' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function unbannedBy()
    {
        return $this->belongsTo(User::class, 'unbanned_by');
    }
}
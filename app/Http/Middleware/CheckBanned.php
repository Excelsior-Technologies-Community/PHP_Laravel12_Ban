<?php
// app/Http/Middleware/CheckBanned.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if user is banned
            if ($user->is_banned) {
                // Check if ban is temporary and expired
                if ($user->banned_until && $user->banned_until->isPast()) {
                    $user->update([
                        'is_banned' => false, 
                        'banned_until' => null,
                        'ban_reason' => null,
                        'banned_by' => null
                    ]);
                } else {
                    Auth::logout();
                    
                    $message = 'Your account has been banned.';
                    if ($user->ban_reason) {
                        $message .= ' Reason: ' . $user->ban_reason;
                    }
                    if ($user->banned_until) {
                        $message .= ' Until: ' . $user->banned_until->format('Y-m-d H:i:s');
                    }
                    
                    return redirect()->route('login')
                        ->with('error', $message);
                }
            }
        }

        return $next($request);
    }
}
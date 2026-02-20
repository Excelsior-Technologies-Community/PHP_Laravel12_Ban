<?php
// app/Http/Controllers/Admin/BanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BanService;
use Illuminate\Http\Request;

class BanController extends Controller
{
    protected $banService;

    public function __construct(BanService $banService)
    {
        $this->banService = $banService;
    }

    public function index()
    {
        $bannedUsers = $this->banService->getBannedUsers();
        return view('admin.bans.index', compact('bannedUsers'));
    }

    public function create(User $user)
    {
        // Make sure the user exists
        if (!$user) {
            return redirect()->route('admin.bans.index')
                ->with('error', 'User not found.');
        }
        
        return view('admin.bans.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'reason' => 'required|string|max:500',
            'ban_until' => 'nullable|date|after:now',
        ]);

        // Check if user exists
        if (!$user || !$user->id) {
            return redirect()->route('admin.bans.index')
                ->with('error', 'User not found.');
        }

        // Check if user is already banned
        if ($user->is_banned) {
            return redirect()->route('admin.bans.index')
                ->with('error', 'User is already banned.');
        }

        try {
            $this->banService->banUser(
                $user,
                auth()->user(),
                $request->reason,
                $request->ban_until
            );

            return redirect()->route('admin.bans.index')
                ->with('success', 'User banned successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error banning user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(User $user)
    {
        $banHistory = $this->banService->getBanHistory($user);
        return view('admin.bans.show', compact('user', 'banHistory'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $this->banService->unbanUser(
                $user,
                auth()->user(),
                $request->reason
            );

            return redirect()->route('admin.bans.index')
                ->with('success', 'User unbanned successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error unbanning user: ' . $e->getMessage());
        }
    }
}
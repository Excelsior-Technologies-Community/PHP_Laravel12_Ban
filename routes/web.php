<?php

use App\Http\Controllers\Admin\BanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected routes with ban check
Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes with ban check and admin middleware
Route::middleware(['auth', 'verified', 'check.banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // List all banned users
    Route::get('/bans', [BanController::class, 'index'])->name('bans.index');
    
    // Show form to ban a specific user
    Route::get('/bans/create/{user}', [BanController::class, 'create'])->name('bans.create');
    
    // Store ban for a specific user
    Route::post('/bans/{user}', [BanController::class, 'store'])->name('bans.store');
    
    // Show ban history for a specific user
    Route::get('/bans/{user}', [BanController::class, 'show'])->name('bans.show');
    
    // Unban a specific user
    Route::put('/bans/{user}', [BanController::class, 'update'])->name('bans.update');
});

require __DIR__ . '/auth.php';
<?php
// app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // ... other middleware
        'check.banned' => \App\Http\Middleware\CheckBanned::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
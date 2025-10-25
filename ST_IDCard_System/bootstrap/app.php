<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest.role' => \App\Http\Middleware\GuestMiddleware::class,
            'auth.admin'  => \App\Http\Middleware\AuthAdminMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'student' => \App\Http\Middleware\RoleMiddleware::class,
            'teacher' => \App\Http\Middleware\RoleMiddleware::class,
            'guest.custom' => \App\Http\Middleware\RedirectIfAuthenticated::class,


        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

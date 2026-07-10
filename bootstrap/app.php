<?php

use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\CompressResponse;
use App\Http\Middleware\PosyanduScopeMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // API routes (dedicated for API endpoints)
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        // Tambahkan SecurityHeaders sebagai global middleware untuk semua request web
        $middleware->web(append: [
            SecurityHeaders::class,
            CompressResponse::class,
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'check.user.status' => CheckUserStatus::class,
            'session.timeout' => SessionTimeout::class,
            'posyandu.scope' => PosyanduScopeMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

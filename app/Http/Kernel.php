<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Add global middleware here if any
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\CheckUserStatus::class,
            // other web middleware
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
        // Add other middleware aliases here
        'medical' => \App\Http\Middleware\PatientMiddleware::class,
        'superadmin' => \App\Http\Middleware\UserMiddleware::class,
        'check.user.status' => \App\Http\Middleware\CheckUserStatus::class,
    ];
}

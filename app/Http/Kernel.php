<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SuperadminMiddleware;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\VerifyEmailMiddleware;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\GalleryRequest;
use App\Http\Requests\MedicalRecordRequest;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\PedukuhanRequest;
use App\Http\Requests\PosyanduRequest;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Global middleware for security, logging, etc.
        TrustProxies::class,
        HandleCors::class,
        ValidatePostSize::class,
        CheckForMaintenanceMode::class,
        PreventRequestsDuringMaintenance::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        SubstituteBindings::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Authenticate::class, // User authentication
            CheckUserStatus::class, // User account status check
            VerifyEmailMiddleware::class, // Verifying email address for users
            StartSession::class, // Start session for user
            ShareErrorsFromSession::class, // Share error messages with session
            SubstituteBindings::class, // Bind route model data
        ],

        'api' => [
            'throttle:api', // API rate limiting
            SubstituteBindings::class, // Route model binding for APIs
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
        // Middleware for authentication and roles
        'auth' => Authenticate::class, // Authentication middleware
        'user' => UserMiddleware::class, // Middleware to ensure user access
        'superadmin' => SuperadminMiddleware::class, // Middleware for superadmins

        // Middleware for account verification and user status
        'check.user.status' => CheckUserStatus::class, // Middleware for checking account status
        'verified' => VerifyEmailMiddleware::class, // Middleware to ensure email verification

        // Middleware for role-based access control (RBAC)
        'role' => RoleMiddleware::class, // Middleware to enforce role-based access

        // Middleware for request validation
        'user.request' => UserRequest::class, // User data validation
        'patient.request' => PatientRequest::class, // Patient data validation
        'schedule.request' => ScheduleRequest::class, // Schedule data validation
        'gallery.request' => GalleryRequest::class, // Gallery data validation
        'article.request' => ArticleRequest::class, // Article data validation
        'medical_record.request' => MedicalRecordRequest::class, // Medical record validation
        'posyandu.request' => PosyanduRequest::class, // Posyandu data validation
        'pedukuhan.request' => PedukuhanRequest::class, // Pedukuhan data validation
    ];
}

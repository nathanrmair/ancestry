<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
        'paid_members_and_providers' => [
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\IncompleteProfileMiddleware::class,
            \App\Http\Middleware\NotAdminMiddleware::class,
            \App\Http\Middleware\Member::cLass,
        ]
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
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \App\Http\Middleware\Verified::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'isVisitor' => \App\Http\Middleware\IsVisitor::class,
        'isProvider' => \App\Http\Middleware\IsProvider::class,
        'not_admin' => \App\Http\Middleware\NotAdminMiddleware::class,
        'incomplete_profile' => \App\Http\Middleware\IncompleteProfileMiddleware::class,
        'not_a_guest_user' => \App\Http\Middleware\Member::cLass,
        'logged_out' => \App\Http\Middleware\LoggedOut::cLass,
    ];
}

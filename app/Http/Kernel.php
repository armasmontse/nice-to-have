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
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\EventCookie::class,
            \App\Http\Middleware\BagsCookie::class,
            \App\Http\Middleware\Cltvo\PreviousUrl::class,
            \App\Http\Middleware\Uft8Access::class,
        ],

        'user' => [
            'auth',
            'throttle:60,1',
            'useraccess',
            'bindings'
        ],


        'admin' => [
            'auth',
            'throttle:60,1',
            'permission:admin_access'
        ],

        'cltvo' => [
            'cltvo_test',
        ],


        'api' => [
            'throttle:60,1',
            // 'bindings',
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
        'auth'              => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'        => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'          => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'               => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'             => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'          => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'cltvo_test'        => \App\Http\Middleware\Cltvo\CLtvoTestUrls::class,

        'permission'        => \App\Http\Middleware\AuthUserPermissions::class,
        'useraccess'        => \App\Http\Middleware\AuthUserAccess::class,
        'onlyajax'          => \App\Http\Middleware\AllowOnlyAjaxRequests::class,

        'anonymous'         => \App\Http\Middleware\AllowOnlyAnonymus::class,

    ];
}

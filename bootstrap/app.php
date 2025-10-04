<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\SpatieContainer\SpatieMiddleware\SpatiePermissionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Modules\MultiGuardAuth\app\Http\Middleware\Authenticate;
use Modules\MultiGuardAuth\app\Http\Middleware\RedirectIfAuthenticated;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->alias([
                'role' => RoleMiddleware::class,
                'permission' => PermissionMiddleware::class,
                'role_or_permission' => RoleOrPermissionMiddleware::class,
                'isAdmin' =>    SpatiePermissionMiddleware::class,

                //from module MultiGuardAuth
                'guest' => RedirectIfAuthenticated::class,
                'auth' => Authenticate::class,
            ])
            ->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

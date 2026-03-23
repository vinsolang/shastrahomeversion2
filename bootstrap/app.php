<?php

use App\Http\Middleware\EnsureAdminUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => EnsureAdminUser::class,
        ]);

        $middleware->redirectGuestsTo(
            static fn (Request $request): string => $request->routeIs('cms.*')
                ? route('cms.login')
                : route('cms.login'),
        );

        $middleware->redirectUsersTo(
            static fn (Request $request): string => $request->routeIs('cms.*')
                ? route('cms.dashboard')
                : route('cms.dashboard'),
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

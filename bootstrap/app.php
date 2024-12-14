<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'Admin' => \App\Http\Middleware\Admin::class,
        ]);
        $middleware->alias([
            'CheckEmailVerified' => \App\Http\Middleware\CheckEmailVerified::class,
        ]);
    })


    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
           '/payment/callback',
        ]);
    })


    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


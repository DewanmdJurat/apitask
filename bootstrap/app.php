<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (Application $app) {
            $app->router->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
//        $middleware->alias([
//            'permission' => CheckPermission::class,
//        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

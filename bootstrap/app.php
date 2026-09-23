<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'site.maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
            'track.traffic' => \App\Http\Middleware\TrackVisitorTraffic::class,
        ]);

        // Pasang middleware pelacak trafik dan pengecekan maintenance secara global untuk web
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitorTraffic::class,
            \App\Http\Middleware\CheckMaintenanceMode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

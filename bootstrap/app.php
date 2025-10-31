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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
            'resepsionis' => \App\Http\Middleware\CheckResepsionisRole::class,
            'dokter' => \App\Http\Middleware\CheckDokterRole::class,
            'pemilik' => \App\Http\Middleware\CheckPemilikRole::class,
            'perawat' => \App\Http\Middleware\CheckPerawatRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

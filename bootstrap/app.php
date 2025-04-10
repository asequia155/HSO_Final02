<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        app('router')->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle custom exceptions
    })
    ->create();

$app->singleton(Schedule::class, function () {
    $schedule = new Schedule;

    // Group scheduled tasks for reservations
    $schedule->command('reservations:discard-expired')->everyMinute();

    $schedule->group(function () use ($schedule) {
        $schedule->command('reservations:discard-expired')
            ->everyMinute()
            ->before(function () {
                Log::info('Starting discard and delete expired reservations task...');
            })
            ->after(function () {
                Log::info('Finished discard and delete expired reservations task.');
            });
    });

    return $schedule;
});
$app->singleton(Schedule::class, function ($app) {
    return new Schedule;
});

$app->booted(function () use ($app) {
    $schedule = $app->make(Illuminate\Console\Scheduling\Schedule::class);

    $schedule->command('batch:check-expiry')->everySecond();
});
return $app;

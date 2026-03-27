<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Session\TokenMismatchException;
// use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\SetLocale::class);
        $middleware->append(\App\Http\Middleware\FixLaravelCloudCookieDomain::class);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->alias([
            'NotUser' => \App\Http\Middleware\NotUser::class,
        ]);
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->reportable(function (TokenMismatchException $exception) {
        //     $request = request();

        //     Log::warning('CSRF token mismatch (419).', [
        //         'url' => $request->fullUrl(),
        //         'method' => $request->method(),
        //         'expects_json' => $request->expectsJson(),
        //         'ip' => $request->ip(),
        //         'user_agent' => $request->userAgent(),
        //         'referer' => $request->headers->get('referer'),
        //         'origin' => $request->headers->get('origin'),
        //         'session_driver' => config('session.driver'),
        //         'session_id' => $request->hasSession() ? $request->session()->getId() : null,
        //         'has_session_cookie' => $request->cookies->has(config('session.cookie')),
        //         'cookie_names' => array_keys($request->cookies->all()),
        //         'header_x_csrf_token' => $request->headers->get('x-csrf-token') ? '[present]' : null,
        //         'header_x_xsrf_token' => $request->headers->get('x-xsrf-token') ? '[present]' : null,
        //     ]);
        // });
    })->create();

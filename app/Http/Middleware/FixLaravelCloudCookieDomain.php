<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixLaravelCloudCookieDomain
{
    /**
     * Laravel Cloud apps often run on `*.laravel.cloud`.
     *
     * Some environments/browsers will ignore cookies set for `Domain=.laravel.cloud`,
     * which causes session / CSRF mismatches (419) for Livewire.
     *
     * Force host-only cookies by unsetting the session domain for that host.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());

        if (str_ends_with($host, '.laravel.cloud')) {
            $sessionDomain = config('session.domain');
            $normalizedSessionDomain = is_string($sessionDomain) ? strtolower($sessionDomain) : null;

            if ($normalizedSessionDomain === '.laravel.cloud' || $normalizedSessionDomain === 'laravel.cloud') {
                config()->set('session.domain', null);
            }
        }

        return $next($request);
    }
}


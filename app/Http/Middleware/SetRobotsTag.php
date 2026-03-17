<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetRobotsTag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Ensure public pages are indexable in production by default.
        // Can be overridden with SEO_ROBOTS_TAG in env.
        $robotsTag = env(
            'SEO_ROBOTS_TAG',
            app()->isProduction() ? 'index, follow' : 'noindex, nofollow'
        );

        $response->headers->set('X-Robots-Tag', $robotsTag, true);

        return $response;
    }
}


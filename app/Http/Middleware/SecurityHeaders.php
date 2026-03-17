<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        $contentType = strtolower((string) $response->headers->get('Content-Type', ''));
        $isHtmlResponse = str_contains($contentType, 'text/html');
        $isSafeMethod = $request->isMethod('GET') || $request->isMethod('HEAD');

        if ($isHtmlResponse) {
            $host = strtolower($request->getHost());
            $isLaravelCloudDomain = str_ends_with($host, '.laravel.cloud');

            // Keep CSP consistent on all portfolio pages to avoid score variance per-route.
            $baseCsp = "default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; ".
                "script-src 'self' 'unsafe-inline'; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ".
                "img-src 'self' data: https://res.cloudinary.com; ".
                "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
                "connect-src 'self'; frame-src 'self' https://www.google.com https://maps.google.com; upgrade-insecure-requests";

            if ($isLaravelCloudDomain) {
                $baseCsp = "default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; ".
                    "script-src 'self' 'unsafe-inline' https://challenges.cloudflare.com; ".
                    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ".
                    "img-src 'self' data: https://res.cloudinary.com; ".
                    "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
                    "connect-src 'self' https://challenges.cloudflare.com; frame-src 'self' https://challenges.cloudflare.com https://www.google.com https://maps.google.com; upgrade-insecure-requests";
            }

            $response->headers->set('Content-Security-Policy', $baseCsp);
        }

        if ($isHtmlResponse && $isSafeMethod && ! $response->headers->has('Cache-Control')) {
            // Keep page revalidation behavior while allowing bfcache (avoid no-store).
            $response->headers->set('Cache-Control', 'private, no-cache, max-age=0, must-revalidate');
        }

        return $response;
    }
}

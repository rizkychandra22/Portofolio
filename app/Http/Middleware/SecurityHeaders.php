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
            $isFilamentPanel = $request->is('dashboard') || $request->is('dashboard/*');

            $viteHotFile = public_path('hot');
            $hasViteDevServer = is_file($viteHotFile);
            $viteDevServerUrl = $hasViteDevServer ? trim((string) @file_get_contents($viteHotFile)) : null;
            $viteOrigins = [];
            $viteConnectOrigins = [];

            if ($viteDevServerUrl) {
                $parsedViteUrl = parse_url($viteDevServerUrl);
                $viteScheme = $parsedViteUrl['scheme'] ?? 'http';
                $viteHost = $parsedViteUrl['host'] ?? null;
                $vitePort = $parsedViteUrl['port'] ?? null;

                if ($viteHost && $vitePort) {
                    // CSP host-sources are inconsistent across browsers for IPv6 literals (e.g. `[::1]`),
                    // so map loopback IPv6 to `localhost` for dev.
                    if ($viteHost === '::1' || $viteHost === '[::1]') {
                        $viteHostForUrl = 'localhost';
                    } else {
                        $viteHostForUrl = $viteHost;
                    }

                    $viteOrigin = "{$viteScheme}://{$viteHostForUrl}:{$vitePort}";
                    $viteOrigins[] = $viteOrigin;

                    $wsScheme = $viteScheme === 'https' ? 'wss' : 'ws';
                    $viteConnectOrigins[] = "{$wsScheme}://{$viteHostForUrl}:{$vitePort}";
                }

                // Common local dev variants (useful when `hot` points to a different host).
                $viteOrigins = array_values(array_unique(array_merge($viteOrigins, [
                    'http://localhost:5173',
                    'http://127.0.0.1:5173',
                ])));
                $viteConnectOrigins = array_values(array_unique(array_merge($viteConnectOrigins, [
                    'ws://localhost:5173',
                    'ws://127.0.0.1:5173',
                ])));
            }

            // Keep CSP consistent on all portfolio pages to avoid score variance per-route.
            $scriptSrc = ["'self'", "'unsafe-inline'"];
            $styleSrc = ["'self'", "'unsafe-inline'", 'https://fonts.googleapis.com', 'https://cdnjs.cloudflare.com', 'https://cdn.jsdelivr.net'];
            $imgSrc = ["'self'", 'data:', 'https://res.cloudinary.com'];
            $fontSrc = ["'self'", 'data:', 'https://fonts.gstatic.com', 'https://cdnjs.cloudflare.com', 'https://cdn.jsdelivr.net'];
            $connectSrc = ["'self'"];
            $frameSrc = ["'self'", 'https://www.google.com', 'https://maps.google.com'];

            // Filament uses Alpine expressions that rely on `new Function(...)` in many environments.
            if ($isFilamentPanel) {
                $scriptSrc[] = "'unsafe-eval'";
            }

            if (! $isLaravelCloudDomain && $viteDevServerUrl) {
                // Allow Vite dev server assets + HMR; without this Filament/Livewire may fall back to plain form GET submits (`?`).
                $scriptSrc[] = "'unsafe-eval'";
                $scriptSrc = array_merge($scriptSrc, $viteOrigins);
                $styleSrc = array_merge($styleSrc, $viteOrigins);
                $connectSrc = array_merge($connectSrc, $viteOrigins, $viteConnectOrigins);
            }

            $directives = [
                "default-src 'self'",
                "base-uri 'self'",
                "object-src 'none'",
                "frame-ancestors 'self'",
                "form-action 'self'",
                'script-src '.implode(' ', array_values(array_unique($scriptSrc))),
                'style-src '.implode(' ', array_values(array_unique($styleSrc))),
                'img-src '.implode(' ', array_values(array_unique($imgSrc))),
                'font-src '.implode(' ', array_values(array_unique($fontSrc))),
                'connect-src '.implode(' ', array_values(array_unique($connectSrc))),
                'frame-src '.implode(' ', array_values(array_unique($frameSrc))),
            ];

            // Avoid breaking local dev (e.g., Vite's http dev server) by upgrading requests to https.
            if ($request->isSecure() && ! $viteDevServerUrl) {
                $directives[] = 'upgrade-insecure-requests';
            }

            $baseCsp = implode('; ', $directives);

            if ($isLaravelCloudDomain) {
                $cloudScriptSrc = array_values(array_unique(array_merge($scriptSrc, ['https://challenges.cloudflare.com'])));
                $cloudConnectSrc = array_values(array_unique(array_merge($connectSrc, ['https://challenges.cloudflare.com'])));
                $cloudFrameSrc = array_values(array_unique(array_merge($frameSrc, ['https://challenges.cloudflare.com'])));

                $cloudDirectives = [
                    "default-src 'self'",
                    "base-uri 'self'",
                    "object-src 'none'",
                    "frame-ancestors 'self'",
                    "form-action 'self'",
                    'script-src '.implode(' ', $cloudScriptSrc),
                    'style-src '.implode(' ', array_values(array_unique($styleSrc))),
                    'img-src '.implode(' ', array_values(array_unique($imgSrc))),
                    'font-src '.implode(' ', array_values(array_unique($fontSrc))),
                    'connect-src '.implode(' ', $cloudConnectSrc),
                    'frame-src '.implode(' ', $cloudFrameSrc),
                ];

                if ($request->isSecure()) {
                    $cloudDirectives[] = 'upgrade-insecure-requests';
                }

                $baseCsp = implode('; ', $cloudDirectives);
            }

            $response->headers->set('Content-Security-Policy', $baseCsp);
        }

        if ($isHtmlResponse && $isSafeMethod && ! $response->headers->has('Cache-Control')) {
            // Prevent edge caches from serving stale CSRF-bearing HTML on the Filament panel (fixes Livewire 419 in some setups).
            if ($request->is('dashboard') || $request->is('dashboard/*')) {
                $response->headers->set('Cache-Control', 'private, no-store, max-age=0');
            } else {
                // Keep page revalidation behavior while allowing bfcache (avoid no-store).
                $response->headers->set('Cache-Control', 'private, no-cache, max-age=0, must-revalidate');
            }
        }

        return $response;
    }
}

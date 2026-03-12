<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! $locale) {
            $locale = $request->segment(1) === 'lang'
                ? $request->segment(2)
                : $request->segment(1);
        }

        if (in_array($locale, ['en', 'id'], true)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale(Session::get('locale', config('app.locale')));
        }

        return $next($request);
    }
}

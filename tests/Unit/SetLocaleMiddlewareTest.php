<?php

namespace Tests\Unit;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class SetLocaleMiddlewareTest extends TestCase
{
    public function test_it_sets_locale_from_route_parameter(): void
    {
        $request = Request::create('/lang/id/home', 'GET');
        $request->setLaravelSession(app('session')->driver());

        $route = new Route('GET', 'lang/{locale}/home', fn () => response('ok'));
        $route->bind($request);
        $request->setRouteResolver(fn () => $route);

        $middleware = new SetLocale();
        $middleware->handle($request, fn () => response('ok'));

        $this->assertSame('id', app()->getLocale());
        $this->assertSame('id', session('locale'));
    }

    public function test_it_falls_back_to_session_locale_when_route_locale_invalid(): void
    {
        $request = Request::create('/lang/fr/home', 'GET');
        $session = app('session')->driver();
        $session->put('locale', 'en');
        $request->setLaravelSession($session);

        $middleware = new SetLocale();
        $middleware->handle($request, fn () => response('ok'));

        $this->assertSame('en', app()->getLocale());
    }
}

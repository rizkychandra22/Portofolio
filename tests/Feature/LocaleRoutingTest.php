<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    public function test_invalid_locale_on_public_route_returns_404(): void
    {
        $response = $this->get('/lang/fr/home');

        $response->assertNotFound();
    }

    public function test_middleware_uses_route_locale_parameter_when_present(): void
    {
        Route::get('/lang/{locale}/_test-locale', fn () => response()->json([
            'locale' => app()->getLocale(),
        ]));

        $response = $this->get('/lang/id/_test-locale');

        $response->assertOk();
        $response->assertJson(['locale' => 'id']);
    }

    public function test_locale_falls_back_to_session_when_route_has_no_locale_parameter(): void
    {
        Route::middleware('web')->get('/_test-locale-session', function (Request $request) {
            $request->session()->put('locale', 'id');

            return response()->json([
                'locale' => app()->getLocale(),
            ]);
        });

        $response = $this->withSession(['locale' => 'id'])->get('/_test-locale-session');

        $response->assertOk();
        $response->assertJson(['locale' => 'id']);
    }
}

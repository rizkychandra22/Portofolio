<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

// Livewire Components
use App\Livewire\Auth\Login;
use App\Livewire\Content\Home;
use App\Livewire\Content\About;
use App\Livewire\Content\Resume;
use App\Livewire\Content\Portofolio;
use App\Livewire\Content\PortofolioDetail;
use App\Livewire\Content\Contact;

use App\Livewire\Control\IndexHome;
use App\Livewire\Control\Image\Profile;
use App\Livewire\Control\Image\Portofolio as ControlPortofolio;
use App\Livewire\Control\Image\PortofolioDetail as DataPortofolioDetail;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (Multi Bahasa)
|--------------------------------------------------------------------------
*/

// Redirect root ke default language
Route::get('/', function () {
    return redirect()->route('home', ['locale' => 'en']);
});

// Group dengan prefix lang/{locale}
Route::prefix('lang/{locale}')
    ->where(['locale' => 'en|id'])
    ->group(function () {
        Route::get('/home', Home::class)->name('home');
        Route::get('/about', About::class)->name('about');
        Route::get('/resume', Resume::class)->name('resume');
        Route::get('/portofolio', Portofolio::class)->name('portofolio');
        Route::get('/portofolio/{id}/details', PortofolioDetail::class)->name('portofolio-detail');
        Route::get('/contact', Contact::class)->name('contact');
    });

// CV Viewer
Route::get('/view/cv/rizky-chandra-khusuma', function () {
    $path = storage_path('app/document/CV_RizkyChandraKhusuma.pdf');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('view.cv');

// Google OAuth Callback
Route::get('/oauth/google/callback', [GoogleAuthController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| Admin / Dashboard Routes (Tanpa Locale)
|--------------------------------------------------------------------------
*/

// Login & Logout
Route::get('/auth/login', Login::class)->name('login');

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('info', 'Anda telah berhasil keluar.');
})->name('logout');

// Dashboard & Control Panel
Route::middleware('NotUser')->group(function () {
    Route::get('/user/home', IndexHome::class)->name('user.home');

    Route::prefix('user/content')->group(function () {
        Route::get('/image/profile', Profile::class)->name('content.profile');
        Route::get('/image/portofolio', ControlPortofolio::class)->name('content.portofolio');
        Route::get('/image/portofolio/details', DataPortofolioDetail::class)->name('detail.portofolio');
    });
});

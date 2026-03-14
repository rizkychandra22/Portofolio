<?php

use Illuminate\Support\Facades\Route;

// Livewire Components
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Resume;
use App\Livewire\Portofolio;
use App\Livewire\PortofolioDetail;
use App\Livewire\Contact;

/*
|--------------------------------------------------------------------------
| Public Routes (Multi Bahasa) Group dengan prefix lang/{locale}
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home', ['locale' => 'en']);
});
Route::prefix('lang/{locale}')
    ->where(['locale' => 'en|id'])
    ->group(function () {
        Route::get('/home', Home::class)->name('home');
        Route::get('/about', About::class)->name('about');
        Route::get('/resume', Resume::class)->name('resume');
        Route::get('/project', Portofolio::class)->name('project');
        Route::get('/project/{id}/details', PortofolioDetail::class)->name('project-detail');
        Route::get('/contact', Contact::class)->name('contact');
    });

// View & Download CV
Route::get('/view/cv/rizky-chandra-khusuma', function () {
    $path = storage_path('app/document/CV_RizkyChandraKhusuma.pdf');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('view.cv');

// Redirect User Login
Route::redirect('/user', '/dashboard/login');
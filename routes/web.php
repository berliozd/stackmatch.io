<?php

use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\Subscribe\CheckoutController;
use App\Http\Controllers\Auth\ProvidersCallbackController;
use App\Http\Middleware\RedirectIfSubscribed;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return Inertia::render('Home/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::prefix('subscribe')->as('subscribe.')->middleware(RedirectIfSubscribed::class)
        ->group(function () {
            Route::get('checkout', CheckoutController::class)->name('checkout');
        });
    Route::get('/billing', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard'));
    })->name('billing');
    Route::get('/user/invoice/{invoice}', function (Request $request, string $invoiceId) {
        return auth()->user()->downloadInvoice($invoiceId);
    })->name('invoices');
    Route::inertia('/websites-search', 'App/WebsitesSearch')->name('websites-search');
    Route::inertia('/websites', 'App/Websites')->name('websites');
});

Route::get('/auth/redirect-github', function () {
    return Socialite::driver('github')->redirect();
})->name('github_login');

// Google
Route::get('/auth/redirect-google', function () {
    return Socialite::driver('google')->redirect();
})->name('google_login');

Route::get(config('services.github.redirect'), ProvidersCallbackController::class);
Route::get(config('services.google.redirect'), ProvidersCallbackController::class);

Route::inertia('/terms', 'Home/Terms')->name('terms');
Route::inertia('/privacy-policy', 'Home/Privacy')->name('privacy-policy');


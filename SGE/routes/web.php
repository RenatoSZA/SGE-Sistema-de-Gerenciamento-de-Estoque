<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('site.index');
Route::post('/login', [\App\Http\Controllers\SiteController::class, 'login'])->name('site.login');
Route::post('/logout-custom', [\App\Http\Controllers\SiteController::class, 'logout'])->name('site.logout');

Route::middleware(['auth'])->group(function () {
Route::middleware([\App\Http\Middleware\CheckAdminOrManager::class])->group(function () {
        Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->except(['show']);
    });

    Route::resource('products', \App\Http\Controllers\ProductController::class)->except(['show']);
    Route::post('products/{product}/adjust-stock', [\App\Http\Controllers\ProductController::class, 'adjustStock'])->name('products.adjustStock');
    
    Route::get('/historico', [\App\Http\Controllers\StockMovementController::class, 'index'])->name('stock.history');
    Route::get('/suporte', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
});




require __DIR__.'/auth.php';

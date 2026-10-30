<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('site.index');
Route::post('/login', [\App\Http\Controllers\SiteController::class, 'login'])->name('site.login');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware([\App\Http\Middleware\CheckAdminOrManager::class])->group(function () {
        Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->except(['show']);
        Route::post('employees/{employee}/reset-password', [\App\Http\Controllers\EmployeeController::class, 'resetPassword'])->name('employees.resetPassword');
        Route::resource('products', \App\Http\Controllers\ProductController::class)->except(['index', 'show']);
        Route::post('/alerts', [\App\Http\Controllers\AlertController::class, 'store'])->name('alerts.store');
        Route::delete('/alerts/{alert}', [\App\Http\Controllers\AlertController::class, 'destroy'])->name('alerts.destroy');
        Route::patch('/suporte/{ticket}/resolve', [\App\Http\Controllers\SupportController::class, 'resolve'])->name('support.resolve');
    });

    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::post('products/{product}/adjust-stock', [\App\Http\Controllers\ProductController::class, 'adjustStock'])->name('products.adjustStock');
    
    Route::get('/historico', [\App\Http\Controllers\StockMovementController::class, 'index'])->name('stock.history');
    Route::get('/suporte', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::post('/suporte', [\App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

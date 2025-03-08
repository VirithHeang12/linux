<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'store']);
});

<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index');
    });

    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthenticationController::class, 'createRegister'])
        ->name('register');

    Route::post('register', [AuthenticationController::class, 'storeRegister'])
        ->name('register.store');

    Route::get('login', [AuthenticationController::class, 'createLogin'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'storeLogin'])
        ->name('login.store');

});

Route::resource('students', StudentController::class);

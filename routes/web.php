<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Pest\Plugins\Profile;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index');
    })->name('index');

    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->name('logout');

    Route::get('students/{student}/delete', [StudentController::class, 'delete'])
        ->name('students.delete');

    Route::resource('students', StudentController::class);
    Route::get("/students/{student}/profile", [ProfileController::class, 'profile'])
        ->name('profile');
});

//@TODO: Add middleware to student routes to check if the logged-in student is expired

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'createLogin'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'storeLogin'])
        ->name('login.store');
});



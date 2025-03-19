<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (auth()->user()->hasRole(RoleEnum::ADMIN)) {
            return redirect()->route('students.index');
        }
        if (auth()->user()->hasRole(RoleEnum::STUDENT)) {
            return redirect()->route('students.profile', [
                'student'   => auth()->user()->userable,
            ])->with([
                'success' => 'Welcome back, ' . auth()->user()->name . '!',
            ]);
        }
    })->name('index');

    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->name('logout');

    Route::get('students/{student}/delete', [StudentController::class, 'delete'])
        ->name('students.delete');

    Route::resource('students', StudentController::class);

    Route::get("/students/{student}/profile", [ProfileController::class, 'profile'])
        ->name('students.profile');
});

//@TODO: Add middleware to student routes to check if the logged-in student is expired

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'createLogin'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'storeLogin'])
        ->name('login.store');
});



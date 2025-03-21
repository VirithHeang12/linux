<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ItClassController;
use App\Http\Controllers\ItClassGenerationAcademicController;
use App\Http\Controllers\ItClassGenerationAcademicStudentController;
use App\Http\Controllers\ItClassGenerationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (auth()->user()->hasRole(RoleEnum::ADMIN)) {
            return redirect()->route('students.index');
        }
        if (auth()->user()->hasRole(RoleEnum::STUDENT)) {
            return redirect()->route('students.profile')->with([
                'success' => 'Welcome back, ' . auth()->user()->name . '!',
            ]);
        }
    })->name('index');

    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->name('logout');

    Route::get("/student/profile", [ProfileController::class, 'profile'])
        ->name('students.profile');
     Route::put("/student/profile/update", [ProfileController::class, 'update'])
        ->name('students.profile.update');

    Route::get('students/{student}/delete', [StudentController::class, 'delete'])
        ->name('students.delete');

    Route::resource('classes', ItClassController::class)
        ->except(['destroy', 'create', 'store', 'edit', 'update', 'show']);

    Route::prefix('classes/{class}/generations')->group(function () {
        Route::get('/', [ItClassGenerationController::class, 'index'])
            ->name('classes.generations.index');

        Route::prefix('{generation}/academics')->group(function () {
            Route::get('/', [ItClassGenerationAcademicController::class, 'index'])
                ->name('classes.generations.academics.index');

            Route::prefix('{academic}/students')->group(function () {
                Route::get('/', [ItClassGenerationAcademicStudentController::class, 'index'])
                    ->name('classes.generations.academics.students.index');
            });
        });
    });

    Route::resource('students', StudentController::class);


});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'createLogin'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'storeLogin'])
        ->name('login.store');

    Route::get('register', [AuthenticationController::class, 'createRegister'])
        ->name('register');

    Route::post('register', [AuthenticationController::class, 'storeRegister'])->name('register.store');
});





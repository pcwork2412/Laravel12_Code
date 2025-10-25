<?php

use App\Http\Controllers\Dashboard\TeacherDashboardController;
use App\Http\Controllers\Password\TeacherPasswordController;
use App\Http\Controllers\Profile\TeacherProfileController;
use App\Http\Controllers\Teacher\TeacherCrudController;
use Illuminate\Support\Facades\Route;


// Route::middleware('role:teacher')->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    // PROFILE 
    Route::resource('teachprofile', TeacherProfileController::class);
    Route::post('teacher/password/update', [TeacherPasswordController::class, 'passwordUpdate'])->name('teacher.password.update');

    
// });

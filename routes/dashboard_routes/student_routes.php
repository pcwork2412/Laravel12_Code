<?php

use Illuminate\Support\Facades\Route;



Route::middleware('role:student')->group(function () {
    Route::get('/student/dashboard', function () {
        return view('school_dashboard.student_dashboard');
    })->name('student.dashboard');

    // Other student routes can be added here
});

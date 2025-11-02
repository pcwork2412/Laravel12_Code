<?php

use App\Http\Controllers\Attendance\StudentAttendanceController;
use App\Http\Controllers\Attendance\TeacherAttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\TeacherDashboardController;
use App\Http\Controllers\Global\GlobalController;
use App\Http\Controllers\Login\AdminAuthController;
use App\Http\Controllers\Login\StudentAuthController;
use App\Http\Controllers\Login\TeacherAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Student\CrudController;
use App\Http\Controllers\Student\ImportController;
use App\Http\Controllers\Student\MarksAllotTableController;
use App\Http\Controllers\Teacher\TeacherCrudController;
use App\Http\Controllers\Register\AdminRegisterController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Glob;

// ---------------- Admin Register ----------------
Route::middleware('guest.role')->prefix('admin')->group(function () {
    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('admin.register.form');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('admin.register');
});







// ---------------- Admin Login ----------------
Route::middleware('guest.role')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ---------------- Teacher Login ----------------
Route::middleware('guest.role')->prefix('teacher')->group(function () {
    Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/login', [TeacherAuthController::class, 'login'])->name('teacher.login.submit');
});
Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');

// ---------------- Student Login ----------------
Route::middleware('guest.role')->prefix('student')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
});
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

Route::middleware(['role:admin,teacher'])->group(function () {
    Route::post('/students/data/print', [CrudController::class, 'downloadPdf'])->name('students.download.pdf');
    Route::post('/students/data/export', [CrudController::class, 'export'])->name('students.export');
    Route::post('/students/bulkdelete', [CrudController::class, 'bulkDelete'])->name('students.bulk.delete');

    Route::get('/students/trashed', [CrudController::class, 'trashed'])->name('students.trashed');
    Route::post('/students/restore/{id}', [CrudController::class, 'restore'])->name('students.restore');
    Route::delete('/students/forcedelete/{id}', [CrudController::class, 'forceDelete'])->name('students.forcedelete');

    Route::post('/students/bulk-restore', [CrudController::class,'bulkRestore']);
Route::delete('/students/bulk-delete', [CrudController::class,'bulkforceDelete']);

    Route::resource('students', CrudController::class);





    // ***********Import Routes
    Route::get('students/show/importform', [ImportController::class, 'importForm'])->name('students.import.form');
    Route::post('students/store/importdata', [ImportController::class, 'import'])->name('students.import.data');

    // Marks Allot Table
    Route::resource('marks', MarksAllotTableController::class);
    Route::post('/marks/{student_id}/update', [MarksAllotTableController::class, 'update']);
    Route::get('/marks/{student_id}/allotNowBtn', [MarksAllotTableController::class, 'allotNowBtn'])->name('marks.allotNowBtn');

    Route::get('/get-sections/{classId}', [MarksAllotTableController::class, 'getSections']);
    Route::get('/get-subjects/{classId}', [MarksAllotTableController::class, 'getSubjects']);
    Route::get('/get-students/{sectionId}', [MarksAllotTableController::class, 'getStudents']);
    // Check Student Marks
    Route::get('/check-student-marks/{student_id}', [MarksAllotTableController::class, 'checkStudentMarks'])->name('marks.check');

    Route::get('/get-section-list/{class_id}', [CrudController::class, 'getSections']);

    // *********** Attendance Routes

    Route::resource('/student_attendance', StudentAttendanceController::class);

    Route::get('/attendance/fetch-students', [StudentAttendanceController::class, 'fetchStudents'])->name('attendance.fetchStudents');

    Route::get('/attendance/report-student', [StudentAttendanceController::class, 'report'])->name('student_attendance.report');


    Route::resource('/teacher_attendance', TeacherAttendanceController::class);
    Route::get('/attendance/fetch-teachers', [TeacherAttendanceController::class, 'fetchTeachers'])->name('attendance.fetchTeachers');

    Route::get('/attendance/report-teachers', [TeacherAttendanceController::class, 'report'])->name('teacher_attendance.report');


    // *********** Global Resuable Routes
    Route::get('/get-global-sections/{classId}', [GlobalController::class, 'getGlobalSections']);
    Route::get('/get-global-students/{sectionId}', [GlobalController::class, 'getGlobalStudents']);

    // 🧾 Trashed Records
Route::get('/teachers/trashed', [TeacherCrudController::class, 'trashed'])->name('teachers.trashed');

// 🔁 Restore Routes
Route::post('/teachers/restore/{id}', [TeacherCrudController::class, 'restore'])->name('teachers.restore');
Route::post('/teachers/restore-all', [TeacherCrudController::class, 'restoreAll'])->name('teachers.restoreAll');

// 💀 Force Delete Routes
Route::delete('/teachers/force-delete/{id}', [TeacherCrudController::class, 'forceDelete'])->name('teachers.forceDelete');
Route::delete('/teachers/force-delete-all', [TeacherCrudController::class, 'forceDeleteAll'])->name('teachers.forceDeleteAll');

// 🧩 Resource CRUD
Route::resource('teachers', TeacherCrudController::class);


    Route::post('/teachers/data/print', [TeacherCrudController::class, 'downloadPdf'])->name('teachers.download.pdf');


    Route::post('/teachers/data/export', [TeacherCrudController::class, 'export'])->name('teachers.export');

    Route::post('/staff/bulk-delete', [TeacherCrudController::class, 'bulkDelete'])->name('staff.bulk.delete');
});




Route::middleware('role:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard_routes/admin_routes.php';
require __DIR__ . '/dashboard_routes/teacher_routes.php';
require __DIR__ . '/dashboard_routes/student_routes.php';
require __DIR__ . '/website_routes/primary_routes.php';
require __DIR__ . '/website_routes/secondary_routes.php';

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
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Glob;

// use App\Http\Controllers\AuthController;

// Route::get('/admin', function () {
//     return view('dashboard');
// });



// ID Card Templates
// Route::get('students/idcardtemplate', [SchoolIdCardController::class, 'idCardTemplate'])->name('students.idcardtemplate');
// Route::post('students/templates/set', [SchoolIdCardController::class, 'templateSet'])->name('students.templates.set');
// ---------------- Admin Login ----------------
// ---------------- Admin Login ----------------
Route::middleware('guest.role')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class,'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class,'login'])->name('admin.login.submit');
});
Route::post('/admin/logout', [AdminAuthController::class,'logout'])->name('admin.logout');

// ---------------- Teacher Login ----------------
Route::middleware('guest.role')->prefix('teacher')->group(function () {
    Route::get('/login', [TeacherAuthController::class,'showLoginForm'])->name('teacher.login');
    Route::post('/login', [TeacherAuthController::class,'login'])->name('teacher.login.submit');
});
Route::post('/teacher/logout', [TeacherAuthController::class,'logout'])->name('teacher.logout');

// ---------------- Student Login ----------------
Route::middleware('guest.role')->prefix('student')->group(function () {
    Route::get('/login', [StudentAuthController::class,'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class,'login'])->name('student.login.submit');
});
Route::post('/student/logout', [StudentAuthController::class,'logout'])->name('student.logout');

Route::middleware(['role:admin,teacher'])->group(function () {
    Route::resource('students', CrudController::class);



    Route::get('/students/data/print', [CrudController::class, 'downloadPdf'])->name('students.download.pdf');


    Route::get('/students/data/export', [CrudController::class, 'export'])->name('students.export');

    Route::post('/students/bulk-delete', [CrudController::class, 'bulkDelete'])
    ->name('students.bulk.delete');

   
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
Route::get('/attendance/fetch-sections', [StudentAttendanceController::class, 'fetchSections'])->name('attendance.fetchSections');
Route::get('/attendance/fetch-students', [StudentAttendanceController::class, 'fetchStudents'])->name('attendance.fetchStudents');



Route::resource('/teacher_attendance', TeacherAttendanceController::class);
Route::get('/attendance/fetch-teachers', [TeacherAttendanceController::class, 'fetchTeachers'])->name('attendance.fetchTeachers');


    // *********** Global Resuable Routes
    Route::get('/get-global-sections/{classId}', [GlobalController::class, 'getGlobalSections']);
    Route::get('/get-global-students/{sectionId}', [GlobalController::class, 'getGlobalStudents']);

        Route::resource('teachers', TeacherCrudController::class);

            Route::get('/teachers/data/print', [TeacherCrudController::class, 'downloadPdf'])->name('teachers.download.pdf');


        Route::get('/teachers/data/export', [TeacherCrudController::class, 'export'])->name('teachers.export');

        Route::post('/staff/bulk-delete', [TeacherCrudController::class, 'bulkDelete'])->name('staff.bulk.delete');

});




Route::middleware('role:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard_routes/admin_routes.php';
require __DIR__ . '/dashboard_routes/teacher_routes.php';
require __DIR__ . '/dashboard_routes/student_routes.php';
require __DIR__ . '/website_routes/primary_routes.php';
require __DIR__ . '/website_routes/secondary_routes.php';

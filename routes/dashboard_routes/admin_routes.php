<?php

use App\Http\Controllers\Master\SchoolMasterController;
use App\Http\Controllers\Master\SectionMasterController;
use App\Http\Controllers\Master\StdClassController;
use App\Http\Controllers\Master\SubjectMasterController;
use App\Http\Controllers\Student\CrudController;
use App\Http\Controllers\Student\ImportController;
use App\Http\Controllers\Student\MarksAllotTableController;
use App\Http\Controllers\Student\MarksheetController;
use App\Http\Controllers\Student\SchoolIdCardController;
use App\Http\Controllers\Student\StudentApprovalController;
use App\Http\Controllers\Teacher\TeacherAllotmentController;
use App\Http\Controllers\Teacher\TeacherClassAllotController;
use App\Http\Controllers\Teacher\TeacherCrudController;
use App\Http\Controllers\Teacher\TeacherIdCardController;
use App\Http\Controllers\Teacher\TeacherImportController;
use Illuminate\Support\Facades\Route;


// Admin Dashboard (Protected)
Route::middleware('auth.admin', 'role:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('school_dashboard.admin_dashboard');
    })->name('admin.dashboard');
});



Route::middleware(['role:admin'])->group(function () {


    // ************Generate Students ID Card Single/Classwise  Routes ************ \\
    // Route::get('students/show/classwiseform', [SchoolIdCardController::class, 'classwiseIdForm'])->name('students.classwiseIdForm');
    // Route::get('students/show/singleform', [SchoolIdCardController::class, 'singleIdForm'])->name('students.singleIdForm');
    // Route::post('students/store/generate/classwise/idcard', [SchoolIdCardController::class, 'genIdCardClasswise'])->name('students.genIdCardClasswise');
    // Route::post('students/store/generate/single/idcard', [SchoolIdCardController::class, 'genIdCardSingle'])->name('students.genIdCardSingle');
    // Add these routes in your web.php



    Route::prefix('admin/students')->name('students.')->group(function () {

        // Existing routes
        Route::get('/classwise-id-form', [SchoolIdCardController::class, 'classwiseIdForm'])->name('classwiseIdForm');
        Route::post('/generate-classwise-id', [SchoolIdCardController::class, 'genIdCardClasswise'])->name('genIdCardClasswise');

        Route::get('/single-id-form', [SchoolIdCardController::class, 'singleIdForm'])->name('singleIdForm');
        Route::post('/generate-single-id', [SchoolIdCardController::class, 'genIdCardSingle'])->name('genIdCardSingle');

        // 🆕 New History Routes
        Route::get('/id-card-history', [SchoolIdCardController::class, 'idCardHistory'])->name('idCardHistory');
        Route::get('/id-card-history/data', [SchoolIdCardController::class, 'getIdCardHistoryData'])->name('idCardHistoryData');
        Route::get('/id-card-history/details/{student_uid}', [SchoolIdCardController::class, 'getStudentHistoryDetails'])->name('studentHistoryDetails');
    });

    //!Masters Routes
    // *****For Class Name
    Route::resource('class_name', StdClassController::class);
    // *****For Section Name
    Route::resource('section_name', SectionMasterController::class);
    // *****For School Name
    Route::resource('school_name', SchoolMasterController::class);
    // *****For Subject Name
    Route::resource('subject_name', SubjectMasterController::class);
    // *********Teachers CRUD Routes



    // ************Generate Teachers ID Card Single/All Routes ************ \\
    // Teacher ID Card Routes
    Route::prefix('admin/teachers')->name('teachers.')->group(function () {

        // ✅ ID Card Generation Routes
        Route::get('/all-id-form', [TeacherIdCardController::class, 'allIdCardForm'])->name('allIdCardForm');
        Route::post('/generate-all-id', [TeacherIdCardController::class, 'genIdAll'])->name('genIdAll');

        Route::get('/single-id-form', [TeacherIdCardController::class, 'singleIdForm'])->name('singleIdForm');
        Route::post('/generate-single-id', [TeacherIdCardController::class, 'genIdCardSingle'])->name('genIdCardSingle');

        // ✅ History Routes
        Route::get('/id-card-history', [TeacherIdCardController::class, 'idCardHistory'])->name('idCardHistory');
        Route::get('/id-card-history/data', [TeacherIdCardController::class, 'getIdCardHistoryData'])->name('idCardHistoryData');
        Route::get('/id-card-history/details/{teacher_id}', [TeacherIdCardController::class, 'getTeacherHistoryDetails'])->name('teacherHistoryDetails');
    });
    // ***********Import Routes
    Route::get('/admin/teachers/importform', [TeacherImportController::class, 'importForm'])->name('teachers.import.form');
    Route::post('/admin/teachers/importdata', [TeacherImportController::class, 'import'])->name('teachers.import.data');


    // ************Teachers Allotment(CLASS,SECTION) BY ADMIN Routes
    Route::resource('admin_teachers_allot', TeacherClassAllotController::class);

    // ************Students Approval Routes
    Route::get('/admin/students/pending-list', [StudentApprovalController::class, 'pendingStudent'])->name('admin.student.pending.list');
    Route::get('/admin/student/aprove-list', [StudentApprovalController::class, 'approveStudent'])->name('admin.student.approve.list');
    Route::get('/admin/student/reject-list', [StudentApprovalController::class, 'rejectStudent'])->name('admin.student.reject.list');
    Route::post('/admin/students/{id}/approve', [StudentApprovalController::class, 'approve'])->name('admin.students.approve');
    Route::post('/admin/students/{id}/reject', [StudentApprovalController::class, 'reject'])->name('admin.students.reject');
    Route::delete('/admin/students/{id}/destroy', [StudentApprovalController::class, 'destroy'])->name('admin.students.destroy');



    // //*********** Class wise marksheet Form Page/Download
    Route::prefix('admin/students')->group(function () {
    
    // ✅ Existing Marksheet Routes
    Route::get('/marksheet/individual', [MarksheetController::class, 'showStudentWise'])->name('students.marksheet.individual');
    Route::post('/marksheet/generate-separate', [MarksheetController::class, 'generateSeparate'])->name('students.marksheet.generateSeparate');
    
    Route::get('/marksheet/classwise', [MarksheetController::class, 'showFormClassWise'])->name('students.marksheet.classwise');
    Route::post('/marksheet/generate', [MarksheetController::class, 'generate'])->name('students.marksheet.generate');
    
    // ✅ NEW: Marksheet History Routes
    Route::get('/marksheet-history', [MarksheetController::class, 'getMarksheetHistoryData'])->name('students.marksheetHistoryData');
    Route::get('/marksheet-history/details/{student_uid}', [MarksheetController::class, 'getStudentMarksheetDetails'])->name('students.marksheetHistoryDetails');
    
    // Helper routes
    Route::get('/sections/{class_id}', [MarksheetController::class, 'individualgetSections'])->name('students.getSections');
    Route::get('/students/{section_id}', [MarksheetController::class, 'individualgetStudents'])->name('students.getStudents');
});
   
});

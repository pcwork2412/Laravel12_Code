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



    //*********** Class wise marksheet Form Page/Download
    Route::get('/marksheet/form', [MarksheetController::class, 'showFormClassWise'])->name('marksheet.form');
    Route::post('/marksheet/generate', [MarksheetController::class, 'generate'])->name('marksheet.generate');
    //*********** Individual Student marksheet Form Page/Download
    Route::get('/marksheet/student/form', [MarksheetController::class, 'showStudentWise'])->name('marksheet.student.form');
    Route::post('/marksheet/student', [MarksheetController::class, 'generateSeparate'])->name('marksheet.student.download');
    // Get Fill From Data
    Route::get('/marksheet/getsections/{class_id}', [MarksheetController::class, 'individualgetSections']);
    Route::get('/marksheet/getstudents/{section_id}', [MarksheetController::class, 'individualgetStudents']);



    // // Marks Allot Table
    // Route::resource('marks', MarksAllotTableController::class);
    // Route::post('/marks/{student_id}/update', [MarksAllotTableController::class, 'update']);
    // Route::get('/marks/{student_id}/allotNowBtn', [MarksAllotTableController::class, 'allotNowBtn'])->name('marks.allotNowBtn');

    // Route::get('/get-sections/{classId}', [MarksAllotTableController::class, 'getSections']);
    // Route::get('/get-subjects/{classId}', [MarksAllotTableController::class, 'getSubjects']);
    // Route::get('/get-students/{sectionId}', [MarksAllotTableController::class, 'getStudents']);
    // // Check Student Marks
    // Route::get('/check-student-marks/{student_id}', [MarksAllotTableController::class, 'checkStudentMarks'])->name('marks.check');

    // Route::get('/get-section-list/{class_id}', [CrudController  ::class, 'getSections']);
});

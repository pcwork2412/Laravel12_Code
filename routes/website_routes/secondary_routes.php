<?php

use Illuminate\Support\Facades\Route;

// Route::get('/web', function () {
//     return view('web_pages.websiteview');
// });

// ************* Website Main Page View Route *************//
Route::view('/', 'web_pages.index')->name('web.index');

//************* About Us View Routes *************//
Route::view('about_us/about', 'web_pages/web_all_pages/about_us/about')->name('about_us.about');
Route::view('about_us/founder', 'web_pages/web_all_pages/about_us/founder')->name('about_us.founder');
Route::view('about_us/manager', 'web_pages/web_all_pages/about_us/manager')->name('about_us.manager');
Route::view('about_us/director', 'web_pages/web_all_pages/about_us/director')->name('about_us.director');
Route::view('about_us/principle', 'web_pages/web_all_pages/about_us/principle')->name('about_us.principle');
Route::view('about_us/schl_detail', 'web_pages/web_all_pages/about_us/schl_detail')->name('about_us.schl_detail');
Route::view('about_us/contact', 'web_pages/web_all_pages/about_us/contact')->name('about_us.contact');

//************* Academics View Routes *************//
Route::view('academics/schl_timing', 'web_pages/web_all_pages/academics/schl_timing')->name('academics.schl_timing');
Route::view('academics/rules_regulation', 'web_pages/web_all_pages/academics/rules_regulation')->name('academics.rules_regulation');
Route::view('academics/result', 'web_pages/web_all_pages/academics/result')->name('academics.result');
Route::view('academics/syllabus', 'web_pages/web_all_pages/academics/syllabus')->name('academics.syllabus');
Route::view('academics/exam_system', 'web_pages/web_all_pages/academics/exam_system')->name('academics.exam_system');

// ************* Activities View Routes *************//
Route::view('activities/activity', 'web_pages/web_all_pages/activities/activity')->name('activities.activity');

// ************* Admission View Routes *************//
Route::view('admission/admission_procedure', 'web_pages/web_all_pages/admission/admission_procedure')->name('admission.admission_procedure');
Route::view('admission/inquiry_form', 'web_pages/web_all_pages/admission/inquiry_form')->name('admission.inquiry_form');
Route::view('admission/admission_form', 'web_pages/web_all_pages/admission/admission_form')->name('admission.admission_form');
Route::view('admission/school_fee', 'web_pages/web_all_pages/admission/school_fee')->name('admission.school_fee');
Route::view('admission/prospectus', 'web_pages/web_all_pages/admission/prospectus')->name('admission.prospectus');

// ************* Facilities View Routes *************//
Route::view('facilities/facility', 'web_pages/web_all_pages/facilities/facility')->name('facilities.facility');

// ************* Downloads View Routes *************//
Route::view('downloads/transfer_certificate', 'web_pages/web_all_pages/downloads/transfer_certificate')->name('downloads.transfer_certificate');


// ************* Gallery View Routes *************//

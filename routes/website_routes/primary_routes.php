<?php

use App\Http\Controllers\Website\Adm_FormController;
use App\Http\Controllers\Website\GalleryController;
use App\Http\Controllers\Website\NewsletterController;
use App\Http\Controllers\Website\WebGallery;
use App\Models\Website\Newsletter;
use Illuminate\Support\Facades\Route;


// ************* Website AdmissionForm Route *************//
Route::get('admission_form/pdf', [Adm_FormController::class, 'admissionFormPdf'])->name('admission_form_pdf');


// ************* Website Gallery Route *************//
Route::resource('gallery', GalleryController::class);

// ************* Website NewsLetter Route *************//
Route::resource('news_letter', NewsletterController::class);



Route::get('/web_gallery', [WebGallery::class, 'gallery'])->name('gallery.photo_gallery');


Route::get('/web_media', [WebGallery::class, 'media'])->name('gallery.media_gallery');


Route::get('/web_video', [WebGallery::class, 'video'])->name('gallery.video_gallery');

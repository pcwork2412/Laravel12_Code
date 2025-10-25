<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website\Gallery;
use Illuminate\Http\Request;

class WebGallery extends Controller
{
   
 public function gallery()
    {
        // Latest images first
        $galleryData = Gallery::orderBy('id', 'desc')->get();

        return view('web_pages.web_all_pages.gallery.photo_gallery', compact('galleryData'));
    }
 public function media()
    {
        return view('web_pages.web_all_pages.gallery.media_gallery');
    }
    
 public function video()
    {
        return view('web_pages.web_all_pages.gallery.video_gallery');
    }
}

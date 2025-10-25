<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
      protected $fillable = ['gallery_id','image_path'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}

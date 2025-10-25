<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;
    
      protected $fillable = ['title','description'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}

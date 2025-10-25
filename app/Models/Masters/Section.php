<?php

namespace App\Models\Masters;

use App\Models\Students\Crud;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';   // आपकी table का नाम
    protected $fillable = ['class_id', 'section_name'];

    public function classModel()
    {
        return $this->belongsTo(StdClass::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Crud::class, 'section_id');
    }
}

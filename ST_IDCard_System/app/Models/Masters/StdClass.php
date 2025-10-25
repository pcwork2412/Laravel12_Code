<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters\Section;
use App\Models\Masters\SubjectMaster;

class StdClass extends Model
{
    use HasFactory;

    // ✅ Table name define
    protected $table = 'std_classes';

    // ✅ Primary key define
    protected $primaryKey = 'id';

    // ✅ Fillable fields
    protected $fillable = ['class_name'];

    // ✅ Relationship with Section
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    // ✅ Relationship with SubjectMaster
    public function subjects()
    {
        return $this->hasMany(SubjectMaster::class, 'class_id');
    }
}

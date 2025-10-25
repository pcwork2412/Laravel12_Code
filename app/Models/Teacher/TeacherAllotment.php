<?php

namespace App\Models\Teacher;

use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAllotment extends Model
{
    use HasFactory;

    protected $table = 'teacher_allotments';

      protected $fillable = ['teacher_id', 'main_class_id', 'main_section_id'];

    public function teacher()
{
    return $this->belongsTo(TeacherCrud::class, 'teacher_id');
}


    public function mainClass() {
        return $this->belongsTo(StdClass::class, 'main_class_id');
    }

    public function mainSection() {
        return $this->belongsTo(Section::class, 'main_section_id');
    }

    public function subClasses() {
        return $this->belongsToMany(StdClass::class, 'teacher_sub_classes', 'allotment_id', 'class_id');
    }

    public function subSections() {
        return $this->belongsToMany(Section::class, 'teacher_sub_sections', 'allotment_id', 'section_id');
    }
}
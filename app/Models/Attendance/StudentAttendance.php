<?php

namespace App\Models\Attendance;

use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
      use HasFactory;

    protected $fillable = [
        'student_id',
        'section_id',
        'class_id',
        'date',
        'status',
        'reason',
    ];

    public function student()
    {
        return $this->belongsTo(Crud::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function class()
    {
        return $this->belongsTo(StdClass::class);
    }
}

<?php

namespace App\Models\Attendance;

use App\Models\Teacher\TeacherCrud;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'status',
        'reason',
    ];

    public function teacher()
    {
        return $this->belongsTo(TeacherCrud::class);
    }
}

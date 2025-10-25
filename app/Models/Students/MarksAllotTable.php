<?php

namespace App\Models\Students;

use App\Models\Masters\SubjectMaster;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class MarksAllotTable extends Model
{
    use HasFactory;
    protected $table = 'marks_allot_tables';
    protected $fillable = [
        'student_id','subject_name','max_marks','obtained_marks','exam_type','year'
    ];

    public function student() {
        return $this->belongsTo(Crud::class, 'student_id');
    }
    public function subject() {
        return $this->belongsTo(SubjectMaster::class, 'subject_name');
    }
}

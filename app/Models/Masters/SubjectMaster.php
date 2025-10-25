<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectMaster extends Model
{
    use HasFactory;

    protected $table = 'subject_masters';
    protected $fillable = ['subject_name', 'subject_code', 'class_id', 'max_marks'];

    public function class()
    {
        return $this->belongsTo(StdClass::class, 'class_id');
    }
}

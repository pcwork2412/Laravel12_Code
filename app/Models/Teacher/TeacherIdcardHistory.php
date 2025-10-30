<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherIdcardHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'mobile',
        'email',
        'generation_type',
        'action_type', // 👈 New field
        'generated_by',
        'generated_at'
    ];

    protected $casts = [
        'generated_at' => 'datetime'
    ];

    // Student ke liye relation (optional)
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher\TeacherCrud::class, 'teacher_id', 'teacher_id');
    }
}

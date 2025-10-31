<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_uid',
        'student_name',
        'class_name',
        'section_name',
        'generation_type',
        'action_type', // 👈 New field
        'generated_by',
        'generated_at'
    ];

    protected $casts = [
        'generated_at' => 'datetime'
    ];

    // Student ke liye relation (optional)
    public function student()
    {
        return $this->belongsTo(\App\Models\Students\Crud::class, 'student_uid', 'student_uid');
    }
}
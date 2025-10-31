<?php

namespace App\Models\Students;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksheetHistory extends Model
{
        use HasFactory;
    protected $table = 'marksheet_histories';

    protected $fillable = [
        'student_uid',
        'student_name',
        'class_name',
        'section_name',
        'generation_type',
        'action_type',
        'generated_by',
        'generated_at'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
use HasFactory;


// mass assignment के लिएfillable
protected $fillable = [
'title',
'description',
'completed',
];


protected $casts = [
'completed' => 'boolean',
];
}
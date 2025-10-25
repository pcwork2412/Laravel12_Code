<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherCrud extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'teacher_cruds';
    protected $fillable =[
        'teacher_id',
        'teacher_name',
        'role',
        'status',
        'password',
        'dob',
        'gender',
        'image',
        'email',
        'mobile',
        'address',
        'city',
        'state',
        'pincode',
        'qualification',
        'experience',
        'documents',
    ];
        protected $hidden = ['password'];

    
    // 👇 Add this relationship
    public function allotments()
    {
        return $this->hasMany(TeacherAllotment::class, 'teacher_id');
    }

    // 👇 Add this boot method
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            // Delete related teacher allotments
            $teacher->allotments()->delete();
        });
    }
}

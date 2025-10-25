<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolMaster extends Model
{
    use HasFactory;

    protected $table ='school_masters';
    protected $fillable =[
        'school_logo',
        'school_name',
        'school_tagline',
        'school_address',
        'school_session',
        'school_principal_sign',
    ];
    
}

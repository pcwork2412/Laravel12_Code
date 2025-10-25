<?php

namespace App\Models\Students;

use App\Http\Controllers\Master\SubjectMasterController;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Masters\SubjectMaster;
use App\Models\Students\MarksAllotTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Crud extends Authenticatable
{
    use HasFactory;
    protected $table = 'cruds';
    protected $fillable = [
        'class_id',
        'section_id',
        'student_uid',
        'promoted_class_name',
        'section',
        'student_name',
        'dob',
        'gender',
        'mother_name',
        'father_name',
        'guardian_name',
        'father_occupation_income',
        'mother_mobile',
        'father_mobile',
        'present_address',
        'permanent_address',
        'local_guardian',
        'state_belong',
        'whatsapp_mobile',
        'alternate_mobile',
        'email_id',
        'aadhaar_number',
        'ration_card_type',
        'physically_handicapped',
        'image',
        'blood_group',
        'height',
        'weight',
        'account_holder_name',
        'bank_name_branch',
        'account_number',
        'ifsc_code',
    ];
       public function classModel()
    {
        return $this->belongsTo(StdClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function marks() {
        return $this->hasMany(MarksAllotTable::class, 'student_id');
    }
    public function subject(){
        return $this->hasMany(SubjectMaster::class, 'subject_name');
    }
    protected $hidden = ['password'];

}

<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Teacher\TeacherCrud;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TeacherImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
     public function model(array $row)
    {   
        $teacherid = null;
        $password = null;

        // 1. Required fields check
        if (empty($row['teacher_name']) || empty($row['email'])) {
            throw new \Exception("Teacher name और Email खाली नहीं हो सकते!");
        }
        // 2. DOB parse
        $dob = null;
        if (!empty($row['dob'])) {
            try {
                $dob = Carbon::parse($row['dob'])->format('Y-m-d');
            } catch (\Exception $e) {
                throw new \Exception("DOB का format गलत है!");
            }
        }   
        $img=null;
          if (isset($row['image']) && !empty($row['image'])) {
            $img = $row['image'];
        } else {
            $img = asset('pos/images/default_profile.jpg');
        }
        
        

         do {
            $uuid = Uuid::uuid4()->toString();
            $teacherid = 'TID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
        } while (TeacherCrud::where('teacher_id', $teacherid)->exists());
         do {
            $uuid = Uuid::uuid4()->toString();
            $password = 'TPW' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
        } while (TeacherCrud::where('teacher_id', bcrypt($password))->exists());
        return new TeacherCrud([
            'teacher_id'    => $teacherid,
            'teacher_name'  => $row['teacher_name'],
            'email'         => $row['email'],
            'password'      => $password,
            'qualification' => $row['qualification'],
            'experience'    => $row['experience'],
            'image'         => $img,
            'role'          => 'teacher',
            'status'        => 'pending', // default
            'dob'           => $dob,
            'gender'        => $row['gender'],
            'mobile'        => $row['mobile'],
            'address'       => $row['address'],
            'city'          => $row['city'],
            'state'         => $row['state'],
            'pincode'       => $row['pincode'],
            'documents'     => 'null',
        ]);
    }
}

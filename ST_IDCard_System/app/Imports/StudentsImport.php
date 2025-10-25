<?php

namespace App\Imports;

use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherAllotment;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentsImport implements ToModel, WithHeadingRow
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $role = Session::get('role'); // admin ya teacher
        $teacher_id = Session::get('id');

        // 1️⃣ Required fields check
        if (empty($row['student_name']) || empty($row['email_id'])) {
            throw new \Exception("Student name और Email खाली नहीं हो सकते!");
        }

        // 2️⃣ DOB parse
        $dob = null;
        if (!empty($row['dob'])) {
            try {
                $dob = Carbon::parse($row['dob'])->format('Y-m-d');
            } catch (\Exception $e) {
                throw new \Exception("DOB का format गलत है!");
            }
        }

        // 3️⃣ Normalize Class & Section
        $className = !empty($row['promoted_class_name'])
            ? preg_replace('/\s+/', '-', ucfirst(strtolower(trim($row['promoted_class_name']))))
            : null;
        $sectionName = !empty($row['section'])
            ? strtoupper(trim($row['section']))
            : null;

        // 4️⃣ Fetch Class & Section from DB
        $class = StdClass::where('class_name', $className)->first();
        if (!$class) {
            throw new \Exception("Class '$className' std_classes में नहीं मिला!");
        }

        $section = Section::where('class_id', $class->id)
            ->where('section_name', $sectionName)
            ->first();
        if (!$section) {
            throw new \Exception("Section '$sectionName' sections में नहीं मिला!");
        }

        // 5️⃣ Teacher role restriction
        if ($role !== 'admin' && $teacher_id) {
            $allotment = TeacherAllotment::where('teacher_id', $teacher_id)->first();
            if ($allotment) {
                if ($class->id != $allotment->main_class_id || $section->id != $allotment->main_section_id) {
                    throw new \Exception("आप केवल अपने allotted class और section का data import कर सकते हैं!");
                }
            }
        }

        // 6️⃣ Unique student_uid generate
        do {
            $uuid = Uuid::uuid4()->toString();
            $studentUid = 'STID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
        } while (Crud::where('student_uid', $studentUid)->exists());

        // 7️⃣ Return Crud model
        return new Crud([
            'class_id' => $class->id,
            'section_id' => $section->id,
            'student_uid' => $studentUid,
            'promoted_class_name' => $className,
            'section' => $sectionName,
            'student_name' => $row['student_name'] ?? null,
            'dob' => $dob,
            'gender' => $row['gender'] ?? null,
            'mother_name' => $row['mother_name'] ?? null,
            'father_name' => $row['father_name'] ?? null,
            'guardian_name' => $row['guardian_name'] ?? null,
            'father_occupation_income' => $row['father_occupation_income'] ?? null,
            'mother_mobile' => $row['mother_mobile'] ?? null,
            'father_mobile' => $row['father_mobile'] ?? null,
            'present_address' => $row['present_address'] ?? null,
            'permanent_address' => $row['permanent_address'] ?? null,
            'local_guardian' => $row['local_guardian'] ?? null,
            'state_belong' => $row['state_belong'] ?? null,
            'whatsapp_mobile' => $row['whatsapp_mobile'] ?? null,
            'alternate_mobile' => $row['alternate_mobile'] ?? null,
            'email_id' => $row['email_id'] ?? null,
            'aadhaar_number' => $row['aadhaar_number'] ?? null,
            'ration_card_type' => $row['ration_card_type'] ?? null,
            'physically_handicapped' => $row['physically_handicapped'] ?? null,
            'image' => $row['image'] ?? null,
            'blood_group' => $row['blood_group'] ?? null,
            'height' => $row['height'] ?? null,
            'weight' => $row['weight'] ?? null,
            'account_holder_name' => $row['account_holder_name'] ?? null,
            'bank_name_branch' => $row['bank_name_branch'] ?? null,
            'account_number' => $row['account_number'] ?? null,
            'ifsc_code' => $row['ifsc_code'] ?? null,
        ]);
    }
}

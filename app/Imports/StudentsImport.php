<?php

namespace App\Imports;

use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherAllotment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public $successCount = 0;
    public $errorDetails = [];

    public function model(array $row)
    {
        try {
            $role = Session::get('role');
            $teacher_id = Session::get('id');

            // ✅ Required field validation
            if (empty($row['student_name'])) {
                throw new \Exception("Row skipped: Student name खाली नहीं हो सकता!");
            }
            if (empty($row['email_id'])) {
                throw new \Exception("Row skipped: Email खाली नहीं हो सकता!");
            }

            // ✅ Unique email check
            if (Crud::where('email_id', $row['email_id'])->exists()) {
                throw new \Exception("Email पहले से मौजूद है: {$row['email_id']}");
            }

            // ✅ DOB parse
            $dob = null;
            if (!empty($row['dob'])) {
                try {
                    $dob = Carbon::parse($row['dob'])->format('Y-m-d');
                } catch (\Exception $e) {
                    throw new \Exception("DOB format गलत है ({$row['dob']})");
                }
            }

            // ✅ Class & Section check
            $className = !empty($row['promoted_class_name'])
                ? preg_replace('/\s+/', '-', ucfirst(strtolower(trim($row['promoted_class_name']))))
                : null;
            $sectionName = !empty($row['section'])
                ? strtoupper(trim($row['section']))
                : null;

            $class = StdClass::where('class_name', $className)->first();
            if (!$class) {
                throw new \Exception("Class '$className' Not Found!");
            }

            $section = Section::where('class_id', $class->id)
                ->where('section_name', $sectionName)
                ->first();
            if (!$section) {
                throw new \Exception("Section '$sectionName' Not Found!");
            }

            // ✅ Teacher restriction
            if ($role !== 'admin' && $teacher_id) {
                $allotment = TeacherAllotment::where('teacher_id', $teacher_id)->first();
                if ($allotment && ($class->id != $allotment->main_class_id || $section->id != $allotment->main_section_id)) {
                    throw new \Exception("आप केवल अपने allotted class और section का data import कर सकते हैं!");
                }
            }

            // ✅ Generate Unique ID
            do {
                $uuid = Uuid::uuid4()->toString();
                $studentUid = 'STID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
            } while (Crud::where('student_uid', $studentUid)->exists());

            // ✅ Default Image
            $img = isset($row['image']) && !empty($row['image'])
                ? $row['image']
                : asset('pos/images/default_profile.jpg');

            // ✅ Save Record
            $this->successCount++;

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
                'image' => $img,
                'blood_group' => $row['blood_group'] ?? null,
                'height' => $row['height'] ?? null,
                'weight' => $row['weight'] ?? null,
                'account_holder_name' => $row['account_holder_name'] ?? null,
                'bank_name_branch' => $row['bank_name_branch'] ?? null,
                'account_number' => $row['account_number'] ?? null,
                'ifsc_code' => $row['ifsc_code'] ?? null,
            ]);

        } catch (\Exception $e) {
            // ❌ Store error details
            $this->errorDetails[] = [
                'row' => $row['student_name'] ?? 'Unknown',
                'reason' => $e->getMessage(),
            ];
        }
    }
}

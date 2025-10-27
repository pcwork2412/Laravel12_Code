<?php

namespace App\Imports;

use App\Models\Teacher\TeacherCrud;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Ramsey\Uuid\Uuid;

class TeacherImport implements ToModel, WithHeadingRow
{
    public $successCount = 0;
    public $errorDetails = [];

    public function model(array $row)
    {
        try {
            // 🔹 Validate required fields
            if (empty($row['teacher_name']) || empty($row['email'])) {
                throw new \Exception("Teacher name या email खाली नहीं हो सकते।");
            }

            // 🔹 Unique email check
            if (TeacherCrud::where('email', $row['email'])->exists()) {
                throw new \Exception("Email पहले से मौजूद है ({$row['email']})");
            }

            // 🔹 DOB parse
            $dob = null;
            if (!empty($row['dob'])) {
                try {
                    $dob = Carbon::parse($row['dob'])->format('Y-m-d');
                } catch (\Exception $e) {
                    throw new \Exception("DOB का format गलत है ({$row['dob']})");
                }
            }

            // 🔹 Default image
            $img = !empty($row['image'])
                ? $row['image']
                : asset('pos/images/default_profile.jpg');

            // 🔹 Unique Teacher ID generate
            do {
                $uuid = Uuid::uuid4()->toString();
                $teacherid = 'TID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
            } while (TeacherCrud::where('teacher_id', $teacherid)->exists());

            // 🔹 Random Password
            $password = 'TPW' . substr(preg_replace('/[^0-9]/', '', Uuid::uuid4()->toString()), 0, 8);

            // 🔹 Create record
            TeacherCrud::create([
                'teacher_id'    => $teacherid,
                'teacher_name'  => $row['teacher_name'],
                'email'         => $row['email'],
                'password'      => bcrypt($password),
                'qualification' => $row['qualification'] ?? null,
                'experience'    => preg_replace('/[^0-9]/', '', $row['experience'] ?? 0),
                'image'         => $img,
                'role'          => 'teacher',
                'status'        => 'pending',
                'dob'           => $dob,
                'gender'        => $row['gender'] ?? null,
                'mobile'        => $row['mobile'] ?? null,
                'address'       => $row['address'] ?? null,
                'city'          => $row['city'] ?? null,
                'state'         => $row['state'] ?? null,
                'pincode'       => $row['pincode'] ?? null,
                'documents'     => null,
            ]);

            $this->successCount++;

        } catch (\Exception $e) {
            // 🔸 Error capture
            $this->errorDetails[] = [
                'row'    => $row['email'] ?? 'Unknown',
                'reason' => $e->getMessage(),
            ];
            Log::error('Teacher Import Error: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Students\Crud as Student;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherAllotment;
use App\Models\Teacher\TeacherCrud;
use App\Models\Students\StdClass;
use App\Models\Students\Section;
use Illuminate\Support\Facades\Hash;

class TeacherDashboardController extends Controller
{
      public function index()
    {
        // 🔹 Development mode — no session, no login check
        // Just manually set a teacher ID to test dashboard data
        $teacher_id = 1; // <--- change this ID as per your testing teacher record

        // 🔹 Fetch teacher info
        $teacherData = TeacherCrud::find($teacher_id);

        // 🔹 Fetch allotment (class + section)
        $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
            ->where('teacher_id', $teacher_id)
            ->first();

        // 🔹 If no allotment found, pass empty data to view
        if (!$allotment) {
            return view('school_dashboard.teacher_dashboard', [
                'teacher' => $teacherData,
                'allotment' => null,
                'students' => collect(),
                'error' => 'No class/section assigned (development mode)',
            ]);
        }

        // 🔹 Fetch students for this teacher’s assigned class & section
        $students = Crud::where('class_id', $allotment->main_class_id)
            ->where('section_id', $allotment->main_section_id)
            ->get();

        // 🔹 Return data to view
        return view('school_dashboard.teacher_dashboard', [
            'teacher' => $teacherData,
            'allotment' => $allotment,
            'students' => $students,
        ]);
    }
    // public function index()
    // {
    //     // ✅ Step 1: Check if user is logged in and role is teacher
    //     if (!Session::has('user_id') || Session::get('role') != 'teacher') {
    //         return redirect()->route('teacher.login')->with('error', 'Please login first.');
    //     }

    //     $teacher_id = Session::get('id');
    //     // ✅ Step 2: Get teacher allotment
    //     $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
    //         ->where('teacher_id', $teacher_id)
    //         ->first();

    //     if (!$allotment) {
    //         return view('school_dashboard.teacher_dashboard')->with('error', 'No class/section assigned.');
    //     }

    //     $main_class_id = $allotment->main_class_id;
    //     $main_section_id = $allotment->main_section_id;

    //     // ✅ Step 3: Fetch students in this class & section
    //     $students = Crud::where('class_id', $main_class_id)
    //         ->where('section_id', $main_section_id)
    //         ->get();
    //     $teacherData = TeacherCrud::find($teacher_id);
    //     // $defaultPw = $teacherData->teacher_id;

    //     // // Check if current password matches teacher_id
    //     // $showPopup = false;

    //     // if (Hash::check($defaultPw, $teacherData->password)) {
    //     //     // Password matches default (teacher_id)
    //     //     $showPopup = true;
    //     // }

    //     return view('school_dashboard.teacher_dashboard', [
    //         'teacher' => $teacherData,
    //         'allotment' => $allotment,
    //         'students' => $students,
    //         // 'showPopup' => $showPopup, // blade me use karenge
    //     ]);
    // }
}

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Teacher\TeacherAllotment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function importForm()
    {
        $role = Session::get('role');
        if ($role === 'teacher') {
            $teacher_id = Session::get('id');

            // ✅ Step 2: Get teacher allotment
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
                ->where('teacher_id', $teacher_id)
                ->first();
            if (!$allotment) {
                return redirect()->back()->with('error', 'No class/section assigned to this teacher.');
            }
            $view = 'School_Dashboard.Teacher_Pages.students.student_import.import_form';
        } elseif ('admin' === 'admin') {
            $view = 'School_Dashboard.Admin_Pages.students.student_import.import_form';
        }
        // $role = Session::get('role');
        // if ($role === 'teacher') {
        //     $view = 'School_Dashboard.Teacher_Pages.students.student_import.import_form';
        // } elseif ($role === 'admin') {
        //     $view = 'School_Dashboard.Admin_Pages.students.student_import.import_form';
        // }
        return view($view);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));
            return back()->with('success', 'Students imported successfully!');
        } catch (\Exception $e) {
            $errorMessage = config('app.debug')
                ? 'Import failed: ' . $e->getMessage()   // ✅ Dev mode (debug = true)
                : 'Import failed! Please try again later.'; // ✅ Production mode (debug = false)

            return back()->with('error', $errorMessage);
        }
    }
}

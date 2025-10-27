<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Teacher\TeacherAllotment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    $import = new StudentsImport();

    Excel::import($import, $request->file('file'));

    $totalSuccess = $import->successCount;
    $totalErrors = count($import->errorDetails);

    // Error messages combine करें
    $errorMessages = '';
    foreach ($import->errorDetails as $err) {
        $errorMessages .= "⛔ {$err['row']}: {$err['reason']}<br>";
    }

    if ($totalErrors > 0) {
        return back()->with([
            'error' => "   Import completed with some errors:
    <ul style='margin-top:5px;'>
        <li>✅ Saved: {$totalSuccess}</li>
        <li>❌ Errors: {$totalErrors}</li>
        <li>⚠️ {$errorMessages}</li>
    </ul>"
        ]);
    }

    return back()->with('success', "✅ Import successful! Total records saved: {$totalSuccess}");
}

}

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
        $maxToShow = '20'; // कितने error दिखाने हैं
        foreach ($import->errorDetails as $index => $err) {
            if ($index < $maxToShow) {
                $errorMessages .= "⛔ {$err['row']}: {$err['reason']}<br>";
            }
        }
        if ($totalErrors > $maxToShow) {
            $remaining = $totalErrors - $maxToShow;
            $errorMessages .= "<b>...और {$remaining} और errors हैं।</b>";
        }

        if ($totalErrors > 0) {
            return back()->with([

                'error' => "
            <div style='
                max-height:150px;
                overflow-y:auto;
                scrollbar-width:thin;
                scrollbar-color:#888 #f1f1f1;
                border:1px solid #e0e0e0;
                background:#fff;
                box-shadow:0 0 8px rgba(0,0,0,0.05);
                font-size:14px;
                line-height:1.4;
            '>
                <div style='font-weight:bold; font-size:15px; color:#d9534f; margin-bottom:6px;'>
                    📦 Import Completed with Some Errors
                </div>
                <div style='margin-bottom:6px;'>
                    ✅ Saved: {$totalSuccess} <br>
                    ❌ Errors: {$totalErrors}
                </div>
                <div style='
                    border-top:1px solid #eee;
                    margin-top:5px;
                    padding-top:5px;
                '>
                    {$errorMessages}
                </div>
            </div>
            "
            ]);
        }

        return back()->with('success', "✅ Import successful! Total records saved: {$totalSuccess}");
    }
}

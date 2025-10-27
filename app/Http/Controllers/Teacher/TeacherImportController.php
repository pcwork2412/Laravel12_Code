<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Imports\TeacherImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class TeacherImportController extends Controller
{
       // Excel Import
    public function importForm()
    {
        
            return view('School_Dashboard.Admin_Pages.teachers.teacher_import.importform');

    }
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $import = new TeacherImport();

    Excel::import($import, $request->file('file'));

    $totalSuccess = $import->successCount;
    $totalErrors = count($import->errorDetails);

    // Combine error messages
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

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
    $errorMessages = '';
    foreach ($import->errorDetails as $err) {
        $errorMessages .= "⛔ {$err['row']}: {$err['reason']}<br>";
    }

    if ($totalErrors > 0) {
        return back()->with([
            'error' => "
            <div>
                <strong>Import completed with some errors:</strong>
                <ul style='margin-top:5px;'>
                    <li>✅ Saved: {$totalSuccess}</li>
                    <li>❌ Errors: {$totalErrors}</li>
                    <li>⚠️ {$errorMessages}</li>
                </ul>
            </div>"
        ]);
    }

    return back()->with('success', "✅ Import successful! Total records saved: {$totalSuccess}");
}
}

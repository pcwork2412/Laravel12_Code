<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Imports\TeacherImport;
use Illuminate\Http\Request;
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
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);

    Excel::import(new TeacherImport, $request->file('file'));

    return back()->with('success', 'Teachers imported successfully!');
}
}

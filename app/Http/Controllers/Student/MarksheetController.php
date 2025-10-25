<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use Illuminate\Http\Request;
use App\Models\Students\Crud;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Container\Attributes\Log;

class MarksheetController extends Controller
{
    public function individualgetSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }

    public function individualgetStudents($section_id)
    {
        $students = Crud::where('section_id', $section_id)->get();
        return response()->json($students);
    }
    // Individual Student marksheet download form
    public function showStudentWise()
    {
        $classes = StdClass::orderBy('class_name', 'asc')->get();

        // ✅ सिर्फ unique sections लाओ
        $sections = Section::select('section_name')->distinct()->pluck('section_name');


        return view('School_Dashboard.Admin_Pages.students.marksheet_print_form.individual', compact('classes', 'sections'));
    }

    // Individual Student marksheet download
 public function generateSeparate(Request $request)
{
    try {
        // ✅ Validation with user-friendly messages
        $data = $request->validate([
            'class_name'   => 'required|string|max:20',
            'section_name'      => 'required|string',
            'student_uid'  => 'required|alpha_num|max:20',
        ], [
            'class_name.required'   => 'Class name is required.',
            'class_name.string'     => 'Class name must be a valid text.',
            'class_name.max'        => 'Class name is too long.',
            'section.required'      => 'Section is required.',
            'section.string'        => 'Section must be a valid text.',
            // 'section.max'           => 'Section is too long.',
            'student_uid.required'  => 'Student UID is required.',
            'student_uid.alpha_num' => 'Student UID must contain only letters and numbers.',
            'student_uid.max'       => 'Student UID is too long.',
        ]);

        $class       = $data['class_name'];
        $section     = $data['section_name'];
        $student_uid = $data['student_uid'];
        // dd($class,$section,$student_uid);

        // ✅ Fetch school info
        $school = SchoolMaster::first();
        if (!$school) {
            return back()->with('error', 'School details not found. Please contact admin.');
        }

        // ✅ Fetch student with marks
        $student = Crud::where('class_id', $class)
            ->where('section_id', $section)
            ->where('student_uid', $student_uid)
            ->with('marks')
            ->first();

        if (!$student) {
            return back()->with('error', "No student found with the given Class, Section, and UID.");
        }

        if ($student->marks->isEmpty()) {
            return back()->with('error', "Student {$student->student_name} has no marks allotted yet.");
        }

        // ✅ Generate PDF
        $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.students.marksheet_print_form.pdf.temp2', [
            'students'       => collect([$student]),
            'class'          => $class,
            'school_logo'    => $school->school_logo,
            'school_name'    => $school->school_name,
            'school_address' => $school->school_address,
            'school_tagline' => $school->school_tagline,
            'school_session' => $school->school_session,
            'school'         => $school->school_principal_sign,
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('footer-right', '[page] of [toPage]');

        $fileName = "marksheet_{$class}_{$section}_{$student_uid}.pdf";
        $action   = $request->action ?? 'generate';

        if ($action === 'preview') {
            return $pdf->stream($fileName);
        } elseif ($action === 'generate') {
            return $pdf->download($fileName);
        } else {
            abort(400, 'Invalid action');
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        // ✅ Validation errors
        return back()->withErrors($e->errors())->withInput();

    } catch (\RuntimeException $e) {
        // ❌ PDF generate error
        return back()->with('error', 'Failed to generate PDF. Please contact support.');

    } catch (\Exception $e) {
        // ✅ Catch-all for unexpected errors
        $errorMessage = 'Unexpected error occurred. Please contact support.';

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'error',
                'message' => $errorMessage,
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } else {
            return back()->with([
                'status'  => 'error',
                'message' => $errorMessage,
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ]);
        }
    }
}




    public function showFormClassWise()
    {
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        $sections = Section::select('section_name')->distinct()->pluck('section_name');
 

        return view('School_Dashboard.Admin_Pages.students.marksheet_print_form.classwise', compact('classes','sections'));
    }
    // PDF generate करें
    public function generate(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'promoted_class_name' => 'required|string',
            'section_name' => 'required|string',
        ]);

        $class = $request->promoted_class_name;
        $section = $request->section_name;


        // ✅ Students + marks eager load
        $students = Crud::where('promoted_class_name', $class)
            ->where('section', $section)
            ->with('marks')
            ->orderBy('student_name')
            ->get();
        $school = SchoolMaster::first();

           // ❌ Agar class me koi student nahi mila
    if ($students->isEmpty()) {
        // Section ke basis par bhi check
        if(empty($section)) {
            return back()->with('error',"Class {$class} me section select nahi hua.");
        } else {
            return back()->with('error',"Class {$class} ke section {$section} me koi student nahi mila.");
        }
    }

        // ✅ सिर्फ उन्हीं students को लो जिनके पास marks allot हुए हैं
        $studentsWithMarks = $students->filter(function ($student) {
            return $student->marks->isNotEmpty();
        });

        // ❌ अगर किसी भी student को marks allot नहीं हैं
        if ($studentsWithMarks->isEmpty()) {
            return back()->with('error', "Class {$class} ke students ko abhi tak marks allot nahi huye.");
        }

        // ✅ अब सिर्फ वही students PDF में जाएंगे जिनको marks allot हुए हैं
        $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.students.marksheet_print_form.pdf.temp2', [
            'students' => $studentsWithMarks,
            'class'    => $class,
            'school' => $school->school_principal_sign,
            'school_logo' => $school->school_logo,
            'school_name' => $school->school_name,
            'school_address' => $school->school_address,
            'school_tagline' => $school->school_tagline,
            'school_session' => $school->school_session
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('footer-right', '[page] of [toPage]');

        $fileName = "marksheet_{$class}.pdf";
        $action = $request->action ?? 'generate'; // default download

        if ($action === 'preview') {
            return $pdf->stream($fileName);
        } elseif ($action === 'generate') {
            return $pdf->download($fileName);
        } else {
            abort(400, 'Invalid action');
        }
        // return $pdf->download("marksheets_{$class}.pdf");
    }
}

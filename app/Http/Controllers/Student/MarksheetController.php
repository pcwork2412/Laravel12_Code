<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use Illuminate\Http\Request;
use App\Models\Students\Crud;
use App\Models\Students\MarksheetHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
                'section_name' => 'required|string',
                'student_uid'  => 'required|alpha_num|max:20',
                'action'       => 'required|in:preview,generate',
            ], [
                'class_name.required'   => 'Class name is required.',
                'section_name.required' => 'Section is required.',
                'student_uid.required'  => 'Student UID is required.',
                'action.required'       => 'Please select an action (Preview or Generate).',
            ]);

            $class       = $data['class_name'];
            $section     = $data['section_name'];
            $student_uid = $data['student_uid'];

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

            // ✅ History Save - ONLY after successful PDF generation
            MarksheetHistory::create([
                'student_uid' => $student->student_uid,
                'student_name' => $student->student_name,
                'class_name' => $student->class_name ?? $class,
                'section_name' => $student->section ?? $section,
                'generation_type' => 'single',
                'action_type' => $request->action,
                'generated_by' => session('user_name') ?? 'admin',
                'generated_at' => now()
            ]);

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
            return back()->withErrors($e->errors())->withInput();
        } catch (\RuntimeException $e) {
            return back()->with('error', 'Failed to generate PDF. Please contact support.');
        } catch (\Exception $e) {
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
        return view('School_Dashboard.Admin_Pages.students.marksheet_print_form.classwise', compact('classes', 'sections'));
    }

    // PDF generate करें (Classwise)
    public function generate(Request $request)
    {
        try {
            // ✅ Validation
            $request->validate([
                'class_name' => 'required|string',
                'section_name' => 'required|string',
                'action' => 'required|in:preview,generate',
            ]);

            $class = $request->class_name;
            $section = $request->section_name;

            // ✅ Students + marks eager load
            $students = Crud::where('class_id', $class)
                ->where('section_id', $section)
                ->with('marks')
                ->orderBy('id', 'asc')
                ->get();
            $school = SchoolMaster::first();

            // ❌ Agar class me koi student nahi mila
            if ($students->isEmpty()) {
                if (empty($section)) {
                    return back()->with('error', "Class {$class} me section select nahi hua.");
                } else {
                    return back()->with('error', "Class {$class} ke section {$section} me koi student nahi mila.");
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

            // ✅ History Save - ONLY after successful PDF generation
            // ✅ Classwise mein sirf EK entry create karo with all student UIDs
            $studentUids = $studentsWithMarks->pluck('student_uid')->implode(',');
            $studentNames = $studentsWithMarks->pluck('student_name')->implode(',');
            
            MarksheetHistory::create([
                'student_uid' => $studentUids, // ✅ All UIDs comma-separated
                'student_name' => $studentNames, // ✅ All names comma-separated
                'class_name' => $class,
                'section_name' => $section,
                'generation_type' => 'classwise',
                'action_type' => $request->action,
                'generated_by' => session('user_name') ?? 'admin',
                'generated_at' => now()
            ]);

            $fileName = "marksheet_{$class}.pdf";
            $action = $request->action ?? 'generate';

            if ($action === 'preview') {
                return $pdf->stream($fileName);
            } elseif ($action === 'generate') {
                return $pdf->download($fileName);
            } else {
                abort(400, 'Invalid action');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // ✅ Marksheet History Page
    public function getMarksheetHistoryData(Request $request)
    {
        try {
            if ($request->ajax()) {
                // ✅ Direct select without complex grouping (since data is already grouped per action)
              $query = MarksheetHistory::select([
    'class_name',
    'section_name',
    'generation_type',
    DB::raw('GROUP_CONCAT(DISTINCT student_uid) as student_uids'),
    DB::raw('GROUP_CONCAT(DISTINCT student_name) as student_names'),
    DB::raw('GROUP_CONCAT(DISTINCT generated_by) as generated_by_list'),
    DB::raw('SUM(CASE WHEN action_type = "preview" THEN 1 ELSE 0 END) as preview_count'),
    DB::raw('SUM(CASE WHEN action_type = "generate" THEN 1 ELSE 0 END) as generate_count'),
    DB::raw('COUNT(*) as total_generations'),
    DB::raw('DATE(MAX(generated_at)) as generation_date'),
    DB::raw('MAX(generated_at) as last_generated')
])->latest();
$query->groupBy('class_name', 'section_name', 'generation_type');


                // ✅ Filter by class
                if ($request->class_name && $request->class_name != 'All') {
                    $query->where('class_name', $request->class_name);
                }

                // ✅ Filter by section
                if ($request->section_name && $request->section_name != 'All') {
                    $query->where('section_name', $request->section_name);
                }

                $query->orderBy('last_generated', 'desc');

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('student_info', function ($row) {
                        if ($row->generation_type === 'classwise') {
                            $studentUids = explode(',', $row->student_uids);
                            $count = count(array_unique($studentUids));

                            return '<button class="btn btn-sm btn-info view-all-students" 
                                        data-uids="' . htmlspecialchars($row->student_uids) . '" 
                                        data-names="' . htmlspecialchars($row->student_names) . '" 
                                        title="View all students">
                                        <i class="fa fa-users"></i> View All Students (' . $count . ')
                                    </button>';
                        } else {
                            $studentUids = explode(',', $row->student_uids);
                            $studentNames = explode(',', $row->student_names);
                            return '<strong>' . $studentNames[0] . '</strong><br>' .
                                '<small class="text-danger fw-bold">(' . $studentUids[0] . ')</small>';
                        }
                    })
                    ->addColumn('class_section', function ($row) {
                        return '<span>' . $row->class_name . '</span> - <span>' . $row->section_name . '</span>';
                    })
                    ->addColumn('generation_type', function ($row) {
                        if ($row->generation_type == 'single') {
                            return '<span class="badge fs-6 fw-normal p-2 bg-danger">SINGLE</span>';
                        } else {
                            return '<span class="badge fs-6 fw-normal p-2 bg-info">CLASSWISE</span>';
                        }
                    })
                    ->addColumn('action_type', function ($row) {
                        $badges = [];
                        if ($row->preview_count > 0) {
                            $badges[] = '<span class="badge bg-success">Preview: ' . $row->preview_count . '</span>';
                        }
                        if ($row->generate_count > 0) {
                            $badges[] = '<span class="badge bg-danger">Generate: ' . $row->generate_count . '</span>';
                        }
                        return implode('<br>', $badges);
                    })
                    ->addColumn('generated_by', function ($row) {
                        $users = explode(',', $row->generated_by_list);
                        $badges = array_map(function ($user) {
                            return '<span class="badge bg-secondary">' . trim($user) . '</span>';
                        }, array_unique($users));
                        return implode(' ', $badges);
                    })
                    ->addColumn('total_count', function ($row) {
                        return '<span class="badge bg-warning text-dark fs-6">' . $row->total_generations . ' times</span>';
                    })
                    ->addColumn('last_generated', function ($row) {
                        $dateTime = new \DateTime($row->last_generated, new \DateTimeZone('UTC'));
                        $dateTime->setTimezone(new \DateTimeZone('Asia/Kolkata'));

                        return $dateTime->format('d-M-Y') .
                            '<br><small>' . $dateTime->format('h:i A') . '</small>';
                    })
                    ->addColumn('actions', function ($row) {
                        $studentUids = explode(',', $row->student_uids);
                        $firstUid = $studentUids[0];
                        $dataType = $row->generation_type === 'classwise' ? 'classwise' : 'single';
                        $dataUids = htmlspecialchars($row->student_uids);
                        $dataNames = htmlspecialchars($row->student_names);

                        return '<button class="btn btn-sm btn-primary view-student-history" 
                                    data-uid="' . $firstUid . '" 
                                    data-type="' . $dataType . '"
                                    data-uids="' . $dataUids . '"
                                    data-names="' . $dataNames . '"
                                    data-class="' . $row->class_name . '"
                                    data-section="' . $row->section_name . '"
                                    data-date="' . $row->generation_date . '"
                                    title="View Complete History">
                                    <i class="fa fa-eye"></i> Details
                                </button>';
                    })
                    ->rawColumns([
                        'student_info',
                        'class_section',
                        'generation_type',
                        'action_type',
                        'generated_by',
                        'total_count',
                        'last_generated',
                        'actions'
                    ])
                    ->make(true);
            }

            $classes = StdClass::orderBy('class_name', 'asc')->get();
            return view('school_dashboard.admin_pages.students.marksheet_print_form.marksheetreport', compact('classes'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ Individual Student Complete History
    public function getStudentMarksheetDetails($student_uid)
    {
        // ✅ Search in both single entries and comma-separated UIDs
        $history = MarksheetHistory::where(function($query) use ($student_uid) {
            $query->where('student_uid', $student_uid)
                  ->orWhere('student_uid', 'LIKE', "%{$student_uid},%")
                  ->orWhere('student_uid', 'LIKE', "%,{$student_uid},%")
                  ->orWhere('student_uid', 'LIKE', "%,{$student_uid}");
        })
        ->orderBy('generated_at', 'desc')
        ->get();

        $totalGenerations = $history->count();
        $uniqueStudentsCount = 1;

        return response()->json([
            'total_generations' => $totalGenerations,
            'unique_students' => $uniqueStudentsCount,
            'history' => $history
        ]);
    }
}
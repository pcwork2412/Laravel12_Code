<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use Illuminate\Http\Request;
use App\Models\Masters\StdClass;
use App\Models\Masters\Section;
use App\Models\Students\Crud;
use App\Models\IdCardHistory;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class SchoolIdCardController extends Controller
{
    /**
     * ✅ Reusable helper function for image to base64 conversion
     */
    private function imageToBase64($relativePath)
    {
        $fullPath = storage_path('app/public/' . $relativePath);
        if (file_exists($fullPath)) {
            $mime = strtolower(mime_content_type($fullPath));
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
        }
        return null;
    }

    public function classwiseIdForm()
    {
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        $sections = Section::select('section_name')->distinct()->pluck('section_name');
        return view('school_dashboard.admin_pages.students.idcard_print_form.idcard_form', compact('classes', 'sections'));
    }

    public function genIdCardClasswise(Request $request)
    {
        try {
            // ✅ Added action validation
            $request->validate([
                'class_name' => 'required|string',
                'section_name' => 'required|string',
                'action' => 'required|in:preview,generate',
            ], [
                'class_name.required' => 'Please Select Any Class.',
                'section_name.required' => 'Please Select Any Section.',
                'action.required' => 'Please select an action (Preview or Generate).',
                'action.in' => 'Invalid action selected.',
            ]);

            $classStudents = Crud::where('class_id', $request->class_name)->get();

            if ($classStudents->isEmpty()) {
                return back()->with('error', 'No students found in this class.');
            }

            $students = Crud::where('class_id', $request->class_name)
                ->where('section_id', $request->section_name)
                ->get();

            if ($students->isEmpty()) {
                return back()->with('error', 'This class has no students in the selected section.');
            }

            $schlMaster = SchoolMaster::first();

            $schoolData = [
                'school_name'           => $schlMaster->school_name,
                'school_address'        => $schlMaster->school_address,
                'school_tagline'        => $schlMaster->school_tagline,
                'school_session'        => $schlMaster->school_session,
                'school_logo'           => $this->imageToBase64($schlMaster->school_logo),
                'school_principal_sign' => $this->imageToBase64($schlMaster->school_principal_sign),
            ];

            // ✅ Generate QR codes for ALL students individually
            $students = $students->map(function ($student) {
                $data = [
                    'student_uid' => $student->student_uid,
                    'student_name' => $student->student_name,
                    'promoted_class_name' => $student->promoted_class_name,
                    'section' => $student->section,
                    'gender' => $student->gender,
                    'dob' => $student->dob,
                    'mother_name' => $student->mother_name,
                    'father_name' => $student->father_name,
                    'father_mobile' => $student->father_mobile,
                    'present_address' => $student->present_address,
                ];
                $qr = QrCode::size(200)->generate(json_encode($data));
                $student->qr_code = 'data:image/svg+xml;base64,' . base64_encode($qr);
                return $student;
            });

            $base64Qr = $students->first()->qr_code ?? '';

            // ✅ Generate PDF first - agar error aaye to history save nahi hogi
            $pdf = SnappyPdf::loadView(
                'school_dashboard.admin_pages.students.idcard_print_form.pdf.card4',
                compact('students', 'base64Qr', 'schoolData')
            )
                ->setOption('page-size', 'A4')
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('print-media-type', true)
                ->setOption('enable-local-file-access', true)
                ->setOption('dpi', 400)
                ->setOption('image-dpi', 400)
                ->setOption('image-quality', 100)
                ->setOption('footer-right', '[page] of [toPage]');

            // ✅ History Save - ONLY after successful PDF generation
            $actionType = $request->action;
            foreach ($students as $student) {
                IdCardHistory::create([
                    'student_uid' => $student->student_uid,
                    'student_name' => $student->student_name,
                    'class_name' => $student->promoted_class_name,
                    'section_name' => $student->section,
                    'generation_type' => 'classwise',
                    'action_type' => $actionType,
                    'generated_by' => session('user_name') ?? 'admin',
                    'generated_at' => now()
                ]);
            }

            if ($request->action === 'preview') {
                return $pdf->stream('id_cards.pdf');
            } else {
                return $pdf->download('id_cards.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function singleIdForm()
    {
        $sections = Section::select('section_name')->distinct()->pluck('section_name');
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        return view('school_dashboard.admin_pages.students.idcard_print_form.singleidform', compact('classes', 'sections'));
    }

    public function genIdCardSingle(Request $request)
    {
        try {
            $request->validate([
                'student_uid' => 'required|string|exists:cruds,student_uid',
                'class_name'  => 'required|string',
                'section_name' => 'required|string',
                'action'      => 'required|in:preview,generate',
            ], [
                'student_uid.required' => 'Student UID is required.',
                'student_uid.exists'   => 'This UID does not exist in records.',
                'class_name.required'  => 'Class name is required.',
                'section_name.required' => 'Section name is required.',
                'action.required'      => 'Please select Action.',
                'action.in'            => 'Please select a valid Action.',
            ]);

            $students = Crud::where('student_uid', $request->student_uid)
                ->where('class_id', $request->class_name)
                ->where('section_id', $request->section_name)
                ->get();

            if ($students->isEmpty()) {
                if (!Crud::where('student_uid', $request->student_uid)->exists()) {
                    return back()->with('error', '❌ Student UID not found.')->withInput();
                }
                if (!Crud::where('student_uid', $request->student_uid)
                    ->where('class_id', $request->class_name)->exists()) {
                    return back()->with('error', '❌ This UID does not belong to the selected class.')->withInput();
                }
                return back()->with('error', '❌ This UID not found in the selected section.')->withInput();
            }

            $student = $students->first();

            // ✅ QR Code generation
            $data = [
                'student_uid' => $student->student_uid,
                'student_name' => $student->student_name,
                'promoted_class_name' => $student->promoted_class_name,
                'section' => $student->section,
                'gender' => $student->gender,
                'dob' => $student->dob,
                'mother_name' => $student->mother_name,
                'father_name' => $student->father_name,
                'father_mobile' => $student->father_mobile,
                'present_address' => $student->present_address,
            ];
            $qr = QrCode::size(200)->generate(json_encode($data));
            $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qr);

            $schlMaster = SchoolMaster::first();

            $schoolData = [
                'school_name'           => $schlMaster->school_name,
                'school_address'        => $schlMaster->school_address,
                'school_tagline'        => $schlMaster->school_tagline,
                'school_session'        => $schlMaster->school_session,
                'school_logo'           => $this->imageToBase64($schlMaster->school_logo),
                'school_principal_sign' => $this->imageToBase64($schlMaster->school_principal_sign),
            ];

            // ✅ Generate PDF first - agar error aaye to history save nahi hogi
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.students.idcard_print_form.pdf.card4', compact('students', 'base64Qr', 'schoolData'))
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('page-width', '210mm')
                ->setOption('page-height', '297mm')
                ->setOption('viewport-size', '1280x1024')
                ->setOption('zoom', 1.0)
                ->setOption('print-media-type', true)
                ->setOption('enable-local-file-access', true)
                ->setOption('dpi', 400)
                ->setOption('image-dpi', 400)
                ->setOption('image-quality', 100)

                ->setOption('footer-right', '[page] of [toPage]');


            // ✅ History Save - ONLY after successful PDF generation
            IdCardHistory::create([
                'student_uid' => $student->student_uid,
                'student_name' => $student->student_name,
                'class_name' => $student->promoted_class_name,
                'section_name' => $student->section,
                'generation_type' => 'single',
                'action_type' => $request->action,
                'generated_by' => session('user_name') ?? 'admin',
                'generated_at' => now()
            ]);

            if ($request->action === 'preview') {
                return $pdf->stream('id_card.pdf');
            } else {
                return $pdf->download('single_id_card.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $messages = collect($e->errors())->flatten()->implode("\n");
            return back()->with('error', $messages)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // ✅ Fixed History View with Correct Grouping
    public function getIdCardHistoryData(Request $request)
    {
        try {
            if ($request->ajax()) {
                // ✅ Group by generation type and date (combine preview + generate)
                $query = IdCardHistory::select([
                    'class_name',
                    'section_name',
                    'generation_type',
                    DB::raw('DATE(generated_at) as generation_date'),
                    DB::raw('GROUP_CONCAT(DISTINCT student_uid) as student_uids'),
                    DB::raw('GROUP_CONCAT(DISTINCT student_name) as student_names'),
                    DB::raw('GROUP_CONCAT(DISTINCT generated_by) as generated_by_list'),
                    DB::raw('SUM(CASE WHEN action_type = "preview" THEN 1 ELSE 0 END) as preview_count'),
                    DB::raw('SUM(CASE WHEN action_type = "generate" THEN 1 ELSE 0 END) as generate_count'),
                    DB::raw('COUNT(*) as total_generations'),
                    DB::raw('MAX(generated_at) as last_generated'),
                    DB::raw('MIN(generated_at) as first_generated')
                ])
                    ->groupBy('class_name', 'section_name', 'generation_type', DB::raw('DATE(generated_at)'));

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
                            // ✅ Show button for "Classwise" type
                            $studentUids = explode(',', $row->student_uids);
                            $count = count(array_unique($studentUids));

                            return '<button class="btn btn-sm btn-info view-all-students" 
                                        data-uids="' . htmlspecialchars($row->student_uids) . '" 
                                        data-names="' . htmlspecialchars($row->student_names) . '" 
                                        title="View all students">
                                        <i class="fa fa-users"></i> View All Students (' . $count . ')
                                    </button>';
                        } else {
                            // ✅ Show individual student info
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
                        // ✅ Show both preview and generate counts
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
            return view('school_dashboard.admin_pages.students.idcard_print_form.idCardHistory', compact('classes'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ Individual Student Complete History
    public function getStudentHistoryDetails($student_uid)
    {
        $history = IdCardHistory::where('student_uid', $student_uid)
            ->orderBy('generated_at', 'desc')
            ->get();

        $totalGenerations = $history->count();
        $uniqueStudentsCount = 1; // ✅ Fixed: Single student ki history hai to count = 1

        return response()->json([
            'total_generations' => $totalGenerations,
            'unique_students' => $uniqueStudentsCount,
            'history' => $history
        ]);
    }
}

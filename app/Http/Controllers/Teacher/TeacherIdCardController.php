<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use App\Models\Teacher\TeacherCrud;
use App\Models\Teacher\TeacherIdcardHistory;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class TeacherIdCardController extends Controller
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

    public function allIdCardForm()
    {
        return view('school_dashboard.admin_pages.teachers.idcard_print_form.idcard_form');
    }

    public function genIdAll(Request $request)
    {
        try {
            // ✅ Validate action
            $request->validate([
                'action' => 'required|in:preview,generate',
            ], [
                'action.required' => 'Please select an action (Preview or Generate).',
                'action.in' => 'Invalid action selected.',
            ]);

            $teachers = TeacherCrud::all();
            
            if ($teachers->isEmpty()) {
                return back()->with('error', 'No Teacher found!');
            }

            // ✅ Get school data
            $schlMaster = SchoolMaster::first();

            $schoolData = [
                'school_name'           => $schlMaster->school_name,
                'school_address'        => $schlMaster->school_address,
                'school_tagline'        => $schlMaster->school_tagline,
                'school_session'        => $schlMaster->school_session,
                'school_logo'           => $this->imageToBase64($schlMaster->school_logo),
                'school_principal_sign' => $this->imageToBase64($schlMaster->school_principal_sign),
            ];
              // ✅ Generate QR codes for ALL teachers individually
            $teachers = $teachers->map(function ($teacher) {
                $data = [
                    'teacher_id' => $teacher->teacher_id,
                    'teacher_name' => $teacher->teacher_name,
                    'mobile' => $teacher->mobile,
                    'gender' => $teacher->gender,
                    'dob' => $teacher->dob,
                    'email' => $teacher->email,
                    'role' => $teacher->role,
                    'city' => $teacher->city,
                    'qualification' => $teacher->qualification,
                    'experience' => $teacher->experience,
                    'address' => $teacher->address,
                ];
                $qr = QrCode::size(200)->generate(json_encode($data));
                $teacher->qr_code = 'data:image/svg+xml;base64,' . base64_encode($qr);
                return $teacher;
            });

            $base64Qr = $teachers->first()->qr_code ?? '';

            // ✅ Generate PDF first - agar error aaye to history save nahi hogi
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.teachers.idcard_print_form.pdf.card4', 
                compact('teachers','base64Qr', 'schoolData'))
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
            foreach ($teachers as $teacher) {
                TeacherIdcardHistory::create([
                    'teacher_id' => $teacher->teacher_id,
                    'teacher_name' => $teacher->teacher_name,
                    'mobile' => $teacher->mobile ?? null,
                    'email' => $teacher->email ?? null,
                    'generation_type' => 'all',
                    'action_type' => $actionType,
                    'generated_by' => session('user_name') ?? 'admin',
                    'generated_at' => now()
                ]);
            }

            if ($request->action === 'preview') {
                return $pdf->stream('teacher_id_cards.pdf');
            } else {
                return $pdf->download('teacher_id_cards.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function singleIdForm()
    {
        $teachers = TeacherCrud::all();
        return view('school_dashboard.admin_pages.teachers.idcard_print_form.singleidform', compact('teachers'));
    }

    public function genIdCardSingle(Request $request)
    {
        try {
            // ✅ Validate inputs
            $request->validate([
                'teacher_id'  => 'required|string|exists:teacher_cruds,teacher_id',
                'action'      => 'required|in:preview,generate',
            ], [
                'teacher_id.required' => 'Teacher ID is required.',
                'teacher_id.exists'   => 'This Teacher ID does not exist in records.',
                'action.required'      => 'Please select Action.',
                'action.in'            => 'Please select a valid Action.',
            ]);

            // ✅ Fetch teacher
            $teachers = TeacherCrud::where('teacher_id', $request->teacher_id)->get();

            if ($teachers->isEmpty()) {
                return back()->with('error', '❌ Teacher ID not found.')->withInput();
            }

            $teacher = $teachers->first();

            // ✅ Get school data
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
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.teachers.idcard_print_form.pdf.card4', 
                compact('teachers', 'schoolData'))
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
            TeacherIdcardHistory::create([
                'teacher_id' => $teacher->teacher_id,
                'teacher_name' => $teacher->teacher_name,
                'mobile' => $teacher->mobile ?? null,
                'email' => $teacher->email ?? null,
                'generation_type' => 'single',
                'action_type' => $request->action,
                'generated_by' => session('user_name') ?? 'admin',
                'generated_at' => now()
            ]);

            if ($request->action === 'preview') {
                return $pdf->stream('teacher_id_card.pdf');
            } else {
                return $pdf->download('teacher_id_card.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $messages = collect($e->errors())->flatten()->implode("\n");
            return back()->with('error', $messages)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // ✅ History View Page
    public function idCardHistory()
    {
        return view('school_dashboard.admin_pages.teachers.idcard_print_form.teacherIdCardHistory');
    }

    // ✅ History Data for DataTable with Grouped Records
    public function getIdCardHistoryData(Request $request)
    {
        try {
            if ($request->ajax()) {
                // ✅ Group by generation details
                $query = TeacherIdcardHistory::select([
                    'generation_type',
                    'action_type',
                    DB::raw('GROUP_CONCAT(DISTINCT teacher_id) as teacher_ids'),
                    DB::raw('GROUP_CONCAT(DISTINCT teacher_name) as teacher_names'),
                    DB::raw('GROUP_CONCAT(DISTINCT generated_by) as generated_by_list'),
                    DB::raw('COUNT(*) as total_generations'),
                    DB::raw('MAX(generated_at) as last_generated'),
                    DB::raw('MIN(generated_at) as first_generated')
                ])
                    ->groupBy('generation_type', 'action_type', DB::raw('DATE(generated_at)'))
                    ->orderBy('last_generated', 'desc');

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('teacher_info', function ($row) {
                        if ($row->generation_type === 'all') {
                            // ✅ Show button for "All" type
                            $teacherIds = explode(',', $row->teacher_ids);
                            $count = count(array_unique($teacherIds));
                            
                            return '<button class="btn btn-sm btn-info view-all-teachers" 
                                        data-ids="' . htmlspecialchars($row->teacher_ids) . '" 
                                        data-names="' . htmlspecialchars($row->teacher_names) . '" 
                                        title="View all teachers">
                                        <i class="fa fa-users"></i> View All Teachers (' . $count . ')
                                    </button>';
                        } else {
                            // ✅ Show individual teacher info
                            $teacherIds = explode(',', $row->teacher_ids);
                            $teacherNames = explode(',', $row->teacher_names);
                            return '<strong>' . $teacherNames[0] . '</strong><br>' .
                                   '<small class="text-primary">ID: ' . $teacherIds[0] . '</small>';
                        }
                    })
                    ->addColumn('generation_type', function ($row) {
                        if ($row->generation_type == 'single') {
                            return '<span class="badge fs-6 fw-normal p-2 bg-danger">SINGLE</span>';
                        } else {
                            return '<span class="badge fs-6 fw-normal p-2 bg-info">ALL</span>';
                        }
                    })
                    ->addColumn('action_type', function ($row) {
                        if ($row->action_type == 'preview') {
                            return '<span class="badge fs-6 fw-normal p-2 bg-success">PREVIEW</span>';
                        } else {
                            return '<span class="badge fs-6 fw-normal p-2 bg-danger">GENERATE</span>';
                        }
                    })
                    ->addColumn('generated_by', function ($row) {
                        $users = explode(',', $row->generated_by_list);
                        $badges = array_map(function($user) {
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
                        if ($row->generation_type === 'all') {
                            $teacherIds = explode(',', $row->teacher_ids);
                            $firstId = $teacherIds[0];
                            return '<button class="btn btn-sm btn-primary view-teacher-history" data-id="' . $firstId . '" data-type="all" title="View Complete History">
                                        <i class="fa fa-eye"></i> Details
                                    </button>';
                        } else {
                            $teacherIds = explode(',', $row->teacher_ids);
                            return '<button class="btn btn-sm btn-primary view-teacher-history" data-id="' . $teacherIds[0] . '" data-type="single" title="View Complete History">
                                        <i class="fa fa-eye"></i> Details
                                    </button>';
                        }
                    })
                    ->rawColumns([
                        'teacher_info',
                        'generation_type',
                        'action_type',
                        'generated_by',
                        'total_count',
                        'last_generated',
                        'actions'
                    ])
                    ->make(true);
            }

            return view('school_dashboard.admin_pages.teachers.idcard_print_form.IdCardHistory');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ Individual Teacher Complete History
    public function getTeacherHistoryDetails($teacher_id)
    {
        try {
            $history = TeacherIdcardHistory::where('teacher_id', $teacher_id)
                ->orderBy('generated_at', 'desc')
                ->get();

            $totalGenerations = $history->count();

            return response()->json([
                'total_generations' => $totalGenerations,
                'history' => $history
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
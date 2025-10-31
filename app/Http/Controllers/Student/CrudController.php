<?php

namespace App\Http\Controllers\Student;

use App\Exports\StudentsExport;
use App\Models\Students\Crud;
use App\Models\Masters\StdClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Masters\Section;
use App\Models\Teacher\TeacherAllotment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables; // ✅ Correct Facade


class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ✅ Role nikal lo
        $role = Session::get('role'); // ya Auth::user()->role
        // dd($role);

        // =========================
        // 🧭 CASE 1: TEACHER ROLE
        // =========================
        if ($role === 'teacher') {
            $teacher_id = Session::get('id');
            // ✅ Step 1: Get teacher allotment (with null safety)
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])->where('teacher_id', $teacher_id)->first();
            if (!$allotment) {
                return back()->with('error', 'No class/section assigned to this teacher.');
            }
            $main_class_id = $allotment->main_class_id;
            $main_section_id = $allotment->main_section_id;
            // ✅ Step 2: Prepare query
            $query = Crud::where('class_id', $main_class_id)->where('section_id', $main_section_id)->select(['id', 'student_uid', 'promoted_class_name', 'section', 'student_name', 'dob', 'gender', 'mother_name', 'father_name', 'guardian_name', 'father_occupation_income', 'mother_mobile', 'father_mobile', 'present_address', 'permanent_address', 'local_guardian', 'state_belong', 'whatsapp_mobile', 'alternate_mobile', 'email_id', 'aadhaar_number', 'ration_card_type', 'physically_handicapped', 'image', 'blood_group', 'height', 'weight', 'account_holder_name', 'bank_name_branch', 'account_number', 'ifsc_code', 'created_at']);
            // ✅ Step 3: AJAX Data Return 
            if ($request->ajax()) {
                return DataTables::of($query)->addIndexColumn()
                    // Name Or Student ID
                    ->addColumn('student_name', function ($row) {
                        return $row->student_name . '<br><small class="text-center text-danger fw-bold">(' . $row->student_uid . ')</small>';
                    })
                    // ✅ Image Column
                    ->addColumn('image', function ($row) {
                        if (filter_var($row->image, FILTER_VALIDATE_URL)) {
                            $src = $row->image;
                        } elseif ($row->image) {
                            $src = asset('storage/' . $row->image);
                        } else {
                            $src = asset('pos/images/default_profile.jpg');
                        }
                        return '<img src="' . $src . '" style="width:60px;height:40px;object-fit:cover;border-radius:20%;">';
                    })->addColumn('actions', function ($row) {
                        return '<a href="' . route('students.show', $row->id) . '" class="btn btn-success btn-sm " title="View"> <i class="fa fa-eye"></i> </a> <button class="btn btn-sm btn-warning editStudentBtn" data-id="' . $row->id . '"><i class="fa fa-pencil"></i></button>';
                    })->rawColumns(['student_name', 'image', 'actions'])->make(true);
            }
            // ✅ Step 4: Fetch Class List for teacher
            $classes = Crud::where('class_id', $main_class_id)->where('section_id', $main_section_id)->first() ?? collect();
            return view('school_dashboard.teacher_pages.students.crud.index', compact('classes'));
        }

        // =========================
        // 🧭 CASE 2: ADMIN ROLE
        // =========================
        elseif ('admin' === 'admin') {

            // ✅ DataTables AJAX
            if ($request->ajax()) {
                $query = Crud::select([
                    'id',
                    'student_uid',
                    'promoted_class_name',
                    'section',
                    'student_name',
                    'dob',
                    'gender',
                    'mother_name',
                    'father_name',
                    'guardian_name',
                    'father_occupation_income',
                    'mother_mobile',
                    'father_mobile',
                    'present_address',
                    'permanent_address',
                    'local_guardian',
                    'state_belong',
                    'whatsapp_mobile',
                    'alternate_mobile',
                    'email_id',
                    'aadhaar_number',
                    'ration_card_type',
                    'physically_handicapped',
                    'image',
                    'blood_group',
                    'height',
                    'weight',
                    'account_holder_name',
                    'bank_name_branch',
                    'account_number',
                    'ifsc_code',
                    'created_at'
                ]);
                // ✅ Filter by class if not "All"
                if ($request->class_id && $request->class_id != 'All') {
                    $query->where('class_id', $request->class_id);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" class="student_checkbox" value="' . $row->id . '">';
                    })
                    // Name Or Student ID
                    ->addColumn('student_name', function ($row) {
                        return $row->student_name . '<br><small class="text-center text-danger fw-bold">(' . $row->student_uid . ')</small>';
                    })
                    ->addColumn('image', function ($row) {
                        if (filter_var($row->image, FILTER_VALIDATE_URL)) {
                            $src = $row->image;
                        } elseif ($row->image) {
                            $src = asset('storage/' . $row->image);
                        } else {
                            $src = asset('pos/images/default_profile.jpg');
                        }
                        return '<img src="' . $src . '" style="width:60px;height:40px;object-fit:cover;border-radius:20%;">';
                    })
                    ->addColumn('actions', function ($row) {
                        return '<a href="' . route('students.show', $row->id) . '" class="btn btn-success btn-sm fs-6 " title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="' . route('student_attendance.show', $row->id) . '" class="btn btn-info btn-sm fs-6 attendenceStudentBtn" title="Attendance Report">
                               <i class="fa fa-user"></i>
                            </a>
                            <button class="btn btn-sm fs-6  btn-warning editStudentBtn" data-id="' . $row->id . '" title="Edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm fs-6  btn-danger deleteStudentBtn" data-id="' . $row->id . '" title="Delete"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['checkbox', 'student_name', 'image', 'actions'])
                    ->make(true);
            }

            // ✅ Admin ke liye Class List
            $classes = StdClass::orderBy('class_name', 'asc')->get() ?? collect();

            return view('school_dashboard.admin_pages.students.crud.index', compact('classes'));
        }

        // =========================
        // 🧭 CASE 3: INVALID ROLE
        // =========================
        else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
    }


    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }

    // public function getStudents($section_id)
    // {
    //     $students = Crud::where('section_id', $section_id)->get();
    //     return response()->json($students);
    // }

    public function create()
    {
        $role = Session::get('role');

        // =========================
        // 🧭 CASE 1: TEACHER ROLE
        // =========================
        if ($role === 'teacher') {
            $teacher_id = Session::get('id');

            // ✅ Step 1: Fetch teacher allotment (class + section)
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
                ->where('teacher_id', $teacher_id)
                ->first();

            if (!$allotment) {
                return redirect()->back()->with('error', 'No class or section assigned to this teacher.');
            }

            $main_class_id = $allotment->main_class_id;
            $main_section_id = $allotment->main_section_id;

            // ✅ Step 2: Fetch classes related to teacher’s assigned class-section
            $classes = Crud::where('class_id', $main_class_id)
                ->where('section_id', $main_section_id)
                ->first() ?? collect();

            // ✅ Step 3: Teacher view
            $view = 'School_Dashboard.Teacher_Pages.students.crud.create';
        }

        // =========================
        // 🧭 CASE 2: ADMIN ROLE
        // =========================
        elseif ('admin' === 'admin') {

            // ✅ Admin: fetch all classes
            $classes = StdClass::orderBy('class_name', 'asc')->get() ?? collect();

            // ✅ Admin view
            $view = 'School_Dashboard.Admin_Pages.students.crud.create';
        }

        // =========================
        // 🧭 CASE 3: INVALID ROLE
        // =========================
        else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // ✅ Final return
        return view($view, compact('classes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ==========================
            // 🔹 Validation Rules + Custom Messages
            // ==========================
            $data = $request->validate([
                'student_name'            => 'required|string|max:255',
                'dob'                     => 'required|date',
                'gender'                  => 'required|string',
                'promoted_class_name'     => 'required|exists:std_classes,id',
                'section_name'            => 'required|exists:sections,id',
                'mother_name'             => 'required|string|max:255',
                'father_name'             => 'required|string|max:255',
                'guardian_name'           => 'required|string|max:255',
                'father_occupation_income' => 'required|string|max:255',
                'mother_mobile'           => 'required|string|max:15',
                'father_mobile'           => 'required|string|max:15',
                'present_address'         => 'required|string|max:255',
                'permanent_address'       => 'required|string|max:255',
                'local_guardian'          => 'required|string|max:255',
                'state_belong'            => 'required|string|max:255',
                'whatsapp_mobile'         => 'required|string|max:15',
                'alternate_mobile'        => 'required|string|max:15',
                'email_id'                => 'required|email',
                'aadhaar_number'          => 'required|string|max:20|unique:cruds,aadhaar_number,' . ($request->id ?? 'NULL') . ',id',
                'ration_card_type'        => 'required|string|max:50',
                'physically_handicapped'  => 'required|string|max:10',
                'blood_group'             => 'nullable|string|max:10',
                'height'                  => 'nullable|string',
                'weight'                  => 'nullable|string',
                'account_holder_name'     => 'nullable|string|max:255',
                'bank_name_branch'        => 'nullable|string|max:255',
                'account_number'          => 'nullable|string|max:50',
                'ifsc_code'               => 'nullable|string|max:20',
                'image'                   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                // ✅ Custom Messages (yaha aur fields ke liye add kar sakte ho)
                'student_name.required' => 'Student name likhna zaroori hai.',
                'dob.required'          => 'Date of birth select karna zaroori hai.',
                'gender.required'       => 'Gender select karna zaroori hai.',
                'promoted_class_name.required' => 'Class select karna zaroori hai.',
                'promoted_class_name.exists'   => 'Selected class galat hai.',
                'section_name.required' => 'Section select karna zaroori hai.',
                'section_name.exists'   => 'Selected section galat hai.',
                'mother_name.required'  => 'Maa ka naam likhna zaroori hai.',
                'father_name.required'  => 'Pita ka naam likhna zaroori hai.',
                'guardian_name.required' => 'Guardian ka naam likhna zaroori hai.',
                'aadhaar_number.required' => 'Aadhaar number likhna zaroori hai.',
                'aadhaar_number.unique'   => 'Ye Aadhaar number already registered hai.',
                'email_id.required'     => 'Email likhna zaroori hai.',
                'email_id.email'        => 'Valid email address likhiye.',
                'image.image'           => 'Sirf image file upload kar sakte ho.',
                'image.mimes'           => 'Sirf jpeg, png, jpg, gif formats allowed hain.',
                'image.max'             => 'Image size 2MB se zyada nahi ho sakti.',
            ]);

            // ==========================
            // 🔹 Get Class & Section
            // ==========================
            $class = StdClass::findOrFail($data['promoted_class_name']);
            $data['class_id'] = $class->id;
            $data['promoted_class_name'] = $class->class_name;

            $section = Section::findOrFail($data['section_name']);
            $data['section_id'] = $section->id;
            $data['section'] = $section->section_name;

            // ==========================
            // 🔹 Handle Image
            // ==========================
            if ($request->hasFile('image')) {
                if ($request->id) {
                    $old = Crud::find($request->id);
                    if ($old && $old->image && Storage::disk('public')->exists($old->image)) {
                        Storage::disk('public')->delete($old->image);
                    }
                }
                $data['image'] = $request->file('image')->store('students', 'public');
            }

            // ==========================
            // 🔹 Generate UID (Only for new)
            // ==========================
            if (!$request->id) {
                do {
                    $uuid = Uuid::uuid4()->toString();
                    $studentUid = 'STID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
                } while (Crud::where('student_uid', $studentUid)->exists());

                $data['student_uid'] = $studentUid;
            }

            // ==========================
            // 🔹 Save Student
            // ==========================
            $student = Crud::create($data);
            \Dispatch(new \App\Jobs\DownloadStudentImage($student));

            return response()->json([
                'status'  => 'success',
                'message' => "Student '{$student->student_name}' created successfully!",
                'student' => $student,
                'class_name'   => $class->class_name,
                'section_name' => $section->section_name,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Validation Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Please fix the following input errors.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            // ✅ Database Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Database error occurred while saving student.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (\Exception $e) {
            // ✅ General Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Unexpected error occurred. Please try again later.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $student = Crud::findOrFail($id);

            // ==========================
            // 🔹 Validation Rules + Custom Messages
            // ==========================
            $data = $request->validate([
                'student_name'            => 'required|string|max:255',
                'dob'                     => 'required|date',
                'gender'                  => 'required|string',
                'promoted_class_name'     => 'required|exists:std_classes,id',
                'section_name'            => 'required|exists:sections,id',
                'mother_name'             => 'required|string|max:255',
                'father_name'             => 'required|string|max:255',
                'guardian_name'           => 'required|string|max:255',
                'father_occupation_income' => 'required|string|max:255',
                'mother_mobile'           => 'required|string|max:15',
                'father_mobile'           => 'required|string|max:15',
                'present_address'         => 'required|string|max:255',
                'permanent_address'       => 'required|string|max:255',
                'local_guardian'          => 'required|string|max:255',
                'state_belong'            => 'required|string|max:255',
                'whatsapp_mobile'         => 'required|string|max:15',
                'alternate_mobile'        => 'required|string|max:15',
                'email_id'                => 'required|email',
                'aadhaar_number'          => 'required|string|max:20|unique:cruds,aadhaar_number,' . $id,
                'ration_card_type'        => 'required|string|max:50',
                'physically_handicapped'  => 'required|string|max:10',
                'blood_group'             => 'nullable|string|max:10',
                'height'                  => 'nullable|string',
                'weight'                  => 'nullable|string',
                'account_holder_name'     => 'nullable|string|max:255',
                'bank_name_branch'        => 'nullable|string|max:255',
                'account_number'          => 'nullable|string|max:50',
                'ifsc_code'               => 'nullable|string|max:20',
                'image'                   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                // ✅ Custom error messages
                'student_name.required' => 'Student name likhna zaroori hai.',
                'dob.required'          => 'Date of birth select karna zaroori hai.',
                'gender.required'       => 'Gender select karna zaroori hai.',
                'promoted_class_name.required' => 'Class select karna zaroori hai.',
                'promoted_class_name.exists'   => 'Selected class galat hai.',
                'section_name.required' => 'Section select karna zaroori hai.',
                'section_name.exists'   => 'Selected section galat hai.',
                'mother_name.required'  => 'Maa ka naam likhna zaroori hai.',
                'father_name.required'  => 'Pita ka naam likhna zaroori hai.',
                'guardian_name.required' => 'Guardian ka naam likhna zaroori hai.',
                'aadhaar_number.required' => 'Aadhaar number likhna zaroori hai.',
                'aadhaar_number.unique'   => 'Ye Aadhaar number already registered hai.',
                'email_id.required'     => 'Email likhna zaroori hai.',
                'email_id.email'        => 'Valid email address likhiye.',
                'image.image'           => 'Sirf image file upload kar sakte ho.',
                'image.mimes'           => 'Sirf jpeg, png, jpg, gif formats allowed hain.',
                'image.max'             => 'Image size 2MB se zyada nahi ho sakti.',
            ]);

            // ==========================
            // 🔹 Class & Section Lookup
            // ==========================
            $class = StdClass::findOrFail($data['promoted_class_name']);
            $data['class_id']   = $class->id;
            $data['promoted_class_name'] = $class->class_name;

            $section = Section::findOrFail($data['section_name']);
            $data['section_id']   = $section->id;
            $data['section'] = $section->section_name;

            // ==========================
            // 🔹 Handle Image
            // ==========================
            if ($request->hasFile('image')) {
                if ($student->image && Storage::disk('public')->exists($student->image)) {
                    Storage::disk('public')->delete($student->image);
                }
                $data['image'] = $request->file('image')->store('students', 'public');
            }

            // ==========================
            // 🔹 Update Student
            // ==========================
            $student->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => "Student '{$student->student_name}' updated successfully!",
                'student' => $student,
                'class_name'   => $class->class_name,
                'section_name' => $section->section_name,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Validation Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Please fix the following input errors.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            // ✅ Database Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Database error occurred while updating student.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (\Exception $e) {
            // ✅ General Error
            return response()->json([
                'status'  => 'error',
                'message' => 'Unexpected error occurred while updating student.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    public function edit($id)
    {
        try {
            // Student record uthao
            $student = Crud::findOrFail($id);

            // Class aur section lookup (agar IDs stored hain)
            $class   = StdClass::find($student->class_id);
            $section = Section::find($student->section_id);

            // Dropdown ke liye data (optional: agar frontend ko full lists chahiye)
            $classes = StdClass::select('id', 'class_name')->get();
            // Sections sirf us class ke liye jisse student linked hai
            $sectionsForClass = Section::where('class_id', $student->class_id)
                ->select('id', 'section_name', 'class_id')
                ->get();

            // Prepare response payload (flat structure jisse frontend asani se use kar sake)
            $payload = $student->toArray();

            // frontend expects selects by ID -> isliye id values bhej rahe hain
            $payload['promoted_class_name'] = $student->class_id;     // class select value (id)
            $payload['class_name'] = $class ? $class->class_name : null; // optional display
            $payload['section_id'] = $student->section_id;            // section select value (id)
            $payload['section'] = $section ? $section->section_name : $student->section; // fallback to stored string

            // image URL for preview
            $payload['image'] = $student->image ?? null;
            $payload['image_url'] = $student->image ? asset('storage/' . $student->image) : null;

            // attach dropdown helper data
            $payload['classes']  = $classes;
            $payload['sections'] = $sectionsForClass;

            return response()->json($payload, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found.'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error while fetching student.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $role = Session::get('role');
        if ($role === 'teacher') {
            $view = 'School_Dashboard.Teacher_Pages.students.crud.show';
        } elseif ('admin' === 'admin') {
            $view = 'School_Dashboard.Admin_Pages.students.crud.show';
        } else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // ✅ Student record uthao
        $student = Crud::findOrFail($id);
        return view($view, compact('student'));
    }

    public function destroy($id)
    {
        try {
            $student = Crud::findOrFail($id);

            $student->delete(); // ✅ Soft delete

            return response()->json([
                'status' => 'success',
                'message' => "छात्र '{$student->student_name}' को Soft Delete कर दिया गया है!"
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student record नहीं मिला!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'कुछ गड़बड़ हो गई: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Crud::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' students soft deleted!']);
    }
    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $students = Crud::onlyTrashed()->select(['id','student_name','student_uid','promoted_class_name','section','deleted_at']);

            return DataTables::of($students)
                ->addIndexColumn()
                 ->editColumn('deleted_at', function ($row) {
            return $row->deleted_at ? $row->deleted_at->format('D, d M Y') : '';
        })
                ->addColumn('actions', function ($row) {
                    return '
                    <button class="btn btn-sm btn-success restore-btn" data-id="' . $row->id . '">Restore</button>
                    <button class="btn btn-sm btn-danger force-del-btn" data-id="' . $row->id . '">Permanent Delete</button>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        
        return view('School_Dashboard.Admin_Pages.students.crud.trashed');
    }



    public function restore($id)
    {
        $student = Crud::onlyTrashed()->findOrFail($id);
        $student->restore();

        return response()->json(['success' => true, 'message' => "{$student->student_name} restored successfully!"]);
    }

    public function forceDelete($id)
    {
        $student = Crud::onlyTrashed()->findOrFail($id);

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->forceDelete();
        return response()->json(['success' => true, 'message' => "{$student->student_name} permanently deleted!"]);
    }
      // Bulk Restore
    public function bulkRestore(Request $request)
    {
        $ids = $request->ids;

        $students = Crud::onlyTrashed()->whereIn('id', $ids)->get();

        foreach ($students as $student) {
            $student->restore();
        }

        return response()->json([
            'success' => true,
            'message' => count($students) . " students restored successfully!"
        ]);
    }

    // Bulk Permanent Delete
    public function bulkforceDelete(Request $request)
    {
        $ids = $request->ids;

        $students = Crud::onlyTrashed()->whereIn('id', $ids)->get();

        foreach ($students as $student) {
            // Delete image if exists
            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }
            $student->forceDelete();
        }

        return response()->json([
            'success' => true,
            'message' => count($students) . " students permanently deleted!"
        ]);
    }

    public function downloadPdf()
    {
        $students = Crud::all();
        // dd($students);
        $pdf = Pdf::loadView('school_dashboard.admin_pages.students.crud.pdf.studentlistpdf', compact('students'));
        return $pdf->download('student_data.pdf');
    }

    public function export(Request $request)
    {
    $fields = $request->input('fields', []);

    if (empty($fields)) {
        return response()->json(['error' => 'Please select at least one field'], 400);
    }

    return Excel::download(new StudentsExport($fields), 'students_export.xlsx');
    }
}

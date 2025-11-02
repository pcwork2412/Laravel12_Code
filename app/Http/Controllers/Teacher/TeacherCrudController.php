<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\TeachersExport;
use App\Http\Controllers\Controller;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherCrud;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class TeacherCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TeacherCrud::select([
                'id',
                'teacher_id',
                'teacher_name',
                'role',
                'status',
                'dob',
                'gender',
                'image',
                'email',
                'mobile',
                'address',
                'city',
                'state',
                'pincode',
                'qualification',
                'experience',
                'documents'
            ])->latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="staff_checkbox" value="' . $row->id . '">';
                })
                // ✅ Name column or Teacher ID
                ->addColumn('teacher_name', function ($row) {
                    return $row->teacher_name . '<br><small class="text-center text-danger fw-bold">(' . $row->teacher_id . ')</small>';
                })
                // ✅ Image column
                ->addColumn('image', function ($row) {
                    $src = $row->image
                        ? (filter_var($row->image, FILTER_VALIDATE_URL)
                            ? $row->image
                            : asset('storage/' . $row->image))
                        : asset('pos/images/default_profile.jpg');
                    return '<img src="' . $src . '" style="width:60px;height:40px;object-fit:cover;border-radius:20%;">';
                })

                // ✅ Documents column
                ->addColumn('documents', function ($row) {
                    return $row->documents
                        ? '<a href="' . asset('storage/' . $row->documents) . '" target="_blank" class="btn btn-sm btn-outline-primary">Download</a>'
                        : '<span class="text-muted">No Document</span>';
                })

                // ✅ Action buttons
                ->addColumn('actions', function ($row) {
                    $viewUrl = route('teachers.show', $row->id);
                    return '
                <a href="' . $viewUrl . '" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                <a href="' . route('teacher_attendance.show', $row->id) . '" class="btn btn-info btn-sm fs-6 attendenceTeacherBtn" title="Attendance Report">
                               <i class="fa fa-user"></i>
                            </a>
                <button class="btn btn-warning btn-sm editTeacherBtn" data-id="' . $row->id . '"><i class="fa fa-pencil text-white"></i></button>
                <button class="btn btn-danger btn-sm deleteTeacherBtn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
            ';
                })

                ->rawColumns(['checkbox', 'teacher_name', 'image', 'documents', 'actions'])
                ->make(true);
        }


        return view('School_Dashboard.Admin_Pages.teachers.teachercrud.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('School_Dashboard.Admin_Pages.teachers.teachercrud.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ Validation
            $data = $request->validate([
                'teacher_name'            => 'required|string|max:255',
                'dob'                     => 'required|date',
                'gender'                  => 'required|string',
                'email'                   => 'required|email|unique:users,email,' . ($request->id ?? 'NULL') . ',id',
                'mobile'                  => 'required|string|max:20',
                'address'                 => 'required|string|max:255',
                'city'                    => 'nullable|string|max:255',
                'state'                   => 'nullable|string|max:255',
                'pincode'                 => 'nullable|numeric',
                'qualification'           => 'nullable|string|max:255',
                'experience'              => 'nullable|string|max:255',
                'documents'               => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // multiple as zip
                'image'                   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status'                  => 'nullable|in:pending,approved,rejected',
            ]);

            // ✅ Handle Image Upload
            if ($request->hasFile('image')) {
                if ($request->id) {
                    $old = TeacherCrud::find($request->id);
                    if ($old && $old->image && Storage::disk('public')->exists($old->image)) {
                        Storage::disk('public')->delete($old->image);
                    }
                }
                $data['image'] = $request->file('image')->store('teachers', 'public');
            }

            // ✅ Handle Documents (zip upload)
            if ($request->hasFile('documents')) {
                $data['documents'] = $request->file('documents')->store('teachers/documents', 'public');
            }
            if (!$request->id) {
                do {
                    $uuid = Uuid::uuid4()->toString();
                    $teacherUid = 'TID' . substr(preg_replace('/[^0-9]/', '', $uuid), 0, 8);
                } while (TeacherCrud::where('teacher_id', $teacherUid)->exists());

                $data['teacher_id'] = $teacherUid;
                $data['password'] = bcrypt($teacherUid);
            }


            // ✅ Create or Update Teacher
            // if ($request->id) {
            //     $teacher = TeacherCrud::findOrFail($request->id);
            //     $teacher->update($data);
            // } else {
            // }
            $teacher = TeacherCrud::create($data);

            return response()->json([
                'status'  => 'success',
                'message' => "Teacher '{$teacher->teacher_name}' has been saved successfully!",
                'teacher' => $teacher,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Please check the input fields.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unexpected error occurred. Please try again later.',
                'debug'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(TeacherCrud $teacherCrud, $id)
    {
        $teacher = TeacherCrud::findOrFail($id);
        // dd($teacher);
        return view('School_Dashboard.Admin_Pages.teachers.teachercrud.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Edit - show teacher data for modal
    public function edit($id)
    {
        $teacher = TeacherCrud::findOrFail($id);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        return response()->json($teacher); // pure teacher object JSON me return
    }

    /**
     * Update the specified resource in storage.
     */
    // Update - handle form submission with documents
    public function update(Request $request, $id)
    {
        $teacher = TeacherCrud::findOrFail($id);

        $data = $request->validate([
            'teacher_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:20',
            'email' => 'required|email|unique:teacher_cruds,email,' . $id,
            'mobile' => 'required|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode'  => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents' => 'nullable|file|mimes:pdf,zip,doc,docx|max:10240', // max 10MB
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        // Handle documents upload
        if ($request->hasFile('documents')) {
            if ($teacher->documents && Storage::disk('public')->exists($teacher->documents)) {
                Storage::disk('public')->delete($teacher->documents);
            }
            $data['documents'] = $request->file('documents')->store('teachers/documents', 'public');
        }

        $teacher->update($data);

        return response()->json([
            'status' => 'success',
            'message' => "Teacher '{$teacher->teacher_name}' updated successfully!",
            'teacher' => $teacher
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    // Delete teacher
   // 🗑️ Soft Delete (Already Exists)
public function destroy($id)
{
    try {
        $teacher = TeacherCrud::findOrFail($id);

        $teacher->delete(); // Soft delete
        return response()->json([
            'status' => true,
            'message' => "Teacher '{$teacher->teacher_name}' has been soft deleted!"
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}

// 🗑️ Bulk Soft Delete (Already Exists)
public function bulkDelete(Request $request)
{
    try {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No staff selected for deletion.']);
        }

        TeacherCrud::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' teachers soft deleted successfully!'
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

// 🧾 Show Trashed Records (For Yajra)
public function trashed(Request $request)
{
    if ($request->ajax()) {
        $teachers = TeacherCrud::onlyTrashed()->select(['id', 'teacher_name','qualification','mobile','deleted_at'])->orderBy('id', 'asc')->latest();

        return datatables()->of($teachers)
            ->addIndexColumn()
             ->editColumn('deleted_at', function ($row) {
            return $row->deleted_at ? $row->deleted_at->format('D, d M Y') : '';
        })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <button class="btn btn-sm btn-success restore-btn" data-id="' . $row->id . '">Restore</button>
                    <button class="btn btn-sm btn-danger force-del-btn" data-id="' . $row->id . '">Permanent Delete</button>
                ';
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }

    return view('School_Dashboard.Admin_Pages.teachers.teachercrud.trashed');
}


// 🔁 Restore Single Teacher
public function restore($id)
{
    try {
        $teacher = TeacherCrud::onlyTrashed()->findOrFail($id);
        $teacher->restore();

        return response()->json(['success' => true, 'message' => "Teacher '{$teacher->teacher_name}' restored successfully!"]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

// 🔁 Restore All Teachers
// 🧩 Bulk Restore
public function restoreAll(Request $request)
{
    $ids = $request->ids;
    if (empty($ids)) {
        return response()->json(['success' => false, 'message' => 'No teachers selected for restore.']);
    }

    $restored = TeacherCrud::onlyTrashed()->whereIn('id', $ids)->restore();

    return response()->json(['success' => true, 'message' => "$restored teachers restored successfully!"]);
}



// 💀 Force Delete (Single)
public function forceDelete($id)
{
    try {
        $teacher = TeacherCrud::onlyTrashed()->findOrFail($id);

        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }
        if ($teacher->documents && Storage::disk('public')->exists($teacher->documents)) {
            Storage::disk('public')->delete($teacher->documents);
        }

        $teacher->forceDelete();

        return response()->json(['success' => true, 'message' => "Teacher '{$teacher->teacher_name}' permanently deleted!"]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

// 💀 Force Delete All
public function forceDeleteAll(Request $request)
{
    $ids = $request->ids;
    if (empty($ids)) {
        return response()->json(['success' => false, 'message' => 'No teachers selected for permanent delete.']);
    }

    $teachers = TeacherCrud::onlyTrashed()->whereIn('id', $ids)->get();
    foreach ($teachers as $teacher) {
        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }
        if ($teacher->documents && Storage::disk('public')->exists($teacher->documents)) {
            Storage::disk('public')->delete($teacher->documents);
        }
        $teacher->forceDelete();
    }

    return response()->json(['success' => true, 'message' => count($ids) . ' teachers permanently deleted!']);
}



   public function downloadPdf(Request $request)
{
    // Get teacher IDs from request
    $teacherIds = json_decode($request->input('teacher_ids', '[]'), true);
    
    // Validation
    if (empty($teacherIds)) {
        return back()->with('error', 'No teachers found on current page');
    }
    
    // Get only teachers with matching IDs (preserving order)
    $teachers = TeacherCrud::whereIn('id', $teacherIds)
                           ->orderByRaw('FIELD(id, ' . implode(',', $teacherIds) . ')')
                           ->get();
    
    // Generate PDF
    $pdf = Pdf::loadView('school_dashboard.admin_pages.teachers.teachercrud.pdf.teacherlist', compact('teachers'));
    
    return $pdf->download('teacher_data_' . date('Y-m-d_H-i-s') . '.pdf');
}

  public function export(Request $request)
{
    $fields = $request->input('fields', []);
    $teacherIds = json_decode($request->input('teacher_ids', '[]'), true);

    if (empty($fields)) {
        return response()->json(['error' => 'Please select at least one field'], 400);
    }

    if (empty($teacherIds)) {
        return response()->json(['error' => 'No teachers found on current page'], 400);
    }

    // Correct parameter order: fields first, IDs second
    return Excel::download(new TeachersExport($fields, $teacherIds), 'teachers_export.xlsx');
}
   
}

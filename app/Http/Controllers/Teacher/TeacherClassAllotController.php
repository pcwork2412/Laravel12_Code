<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Masters\StdClass;
use App\Models\Masters\Section;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherAllotment;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TeacherClassAllotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // ✅ Eager loading for performance
            $data = TeacherAllotment::with(['teacher', 'mainClass', 'mainSection'])->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Safe null check
                ->addColumn('teacher', fn($row) => optional($row->teacher)->teacher_name ?? '-')

                ->addColumn('mainClass', fn($row) => optional($row->mainClass)->class_name ?? '-')

                ->addColumn('mainSection', fn($row) => optional($row->mainSection)->section_name ?? '-')

                        // ✅ View Button Column
        ->addColumn('view_subclass', function ($row) {
            return '
                <button class="btn btn-sm btn-info allotedDataShowModalBtn" 
                        data-id="' . $row->id . '">
                    <i class="fa-solid fa-eye"></i> View Sub Class / Sections
                </button>
            ';
        })
               

                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-sm btn-warning editTAllotBtn" data-id="' . $row->id . '">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger deleteTAllotBtn" data-id="' . $row->id . '">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                ';
                })
                ->rawColumns(['view_subclass', 'action'])
                ->make(true);
        }
        $teachers = TeacherCrud::where('role', 'teacher')->get();
        $classes = StdClass::orderBy('class_name', 'asc')->get();

        // Sections ko ab class_id ke hisaab se unique rakho
        $sections = Section::whereNotNull('class_id')
            ->get()
            ->groupBy('class_id'); // group by class_id, har class ka alag collection

        // $allotedTeachers = TeacherAllotment::with([
        //     'teachers',
        //     'mainClass',
        //     'mainSection',
        //     'subClasses',
        //     'subSections'
        // ])->get();

        return view('school_dashboard.admin_pages.teachers.allotclasses.allotlist', compact(
            'teachers',
            'classes',
            'sections',
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = TeacherCrud::where('role', 'teacher')->get();
    $classes = StdClass::orderBy('class_name', 'asc')->get();

        // Sections ko ab class_id ke hisaab se unique rakho
        $sections = Section::whereNotNull('class_id')
            ->get()
            ->groupBy('class_id'); // group by class_id, har class ka alag collection

        $allotedTeachers = TeacherAllotment::with([
            'teacher',
            'mainClass',
            'mainSection',
            'subClasses',
            'subSections'
        ])->get();

        return view(
            'school_dashboard.admin_pages.teachers.allotclasses.allot',
            compact('teachers', 'classes', 'sections', 'allotedTeachers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'teacher_id'      => 'required|exists:teacher_cruds,id',
        'main_class_id'   => 'required|exists:std_classes,id',
        'sub_class_ids'   => 'array',
        'main_section_id' => 'required|exists:sections,id',
        'sub_section_ids' => 'array',
    ]);

    // ✅ (1) Check if this teacher already allotted anywhere (any class)
    $teacherAlreadyAllotted = TeacherAllotment::where('teacher_id', $request->teacher_id)->first();
    if ($teacherAlreadyAllotted) {
        return response()->json([
            'status' => 'error',
            'message' => 'This teacher is already allotted to another class. One teacher cannot be allotted twice!'
        ], 400);
    }

    // ✅ (2) Check if this main class + section is already assigned to another teacher
    $existingAllotment = TeacherAllotment::where('main_class_id', $request->main_class_id)
        ->where('main_section_id', $request->main_section_id)
        ->where('teacher_id', '!=', $request->teacher_id)
        ->first();

    if ($existingAllotment) {
        return response()->json([
            'status' => 'error',
            'message' => 'This class and section is already allotted to another teacher!'
        ], 400);
    }

    // ✅ (3) Check if same teacher already allotted same class-section (duplicate)
    $duplicateAllotment = TeacherAllotment::where('teacher_id', $request->teacher_id)
        ->where('main_class_id', $request->main_class_id)
        ->where('main_section_id', $request->main_section_id)
        ->first();

    if ($duplicateAllotment) {
        return response()->json([
            'status' => 'error',
            'message' => 'This teacher is already allotted to this same class and section!'
        ], 400);
    }

    // ✅ Save main class/section allotment
    $allotment = TeacherAllotment::create([
        'teacher_id'      => $request->teacher_id,
        'main_class_id'   => $request->main_class_id,
        'main_section_id' => $request->main_section_id,
    ]);

    // ✅ Sync sub-classes
    if ($request->has('sub_class_ids')) {
        $allotment->subClasses()->sync($request->sub_class_ids);
    }

    // ✅ Sync sub-sections (flatten multi-array)
    if ($request->has('sub_section_ids')) {
        $subSections = collect($request->sub_section_ids)->flatten()->toArray();
        $allotment->subSections()->sync($subSections);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Teacher allotted successfully!'
    ], 200);
}


    /**
     * Display the specified resource.
     */
public function show($id)
{
    try {
        $allot = TeacherAllotment::with([
            'teacher',
            'subClasses',
            'subSections'
        ])->findOrFail($id);

        $teacherName = optional($allot->teacher)->teacher_name ?? '-';

        $classes = collect();
        $sections = collect();

        foreach ($allot->subClasses as $class) {
            // ✅ सिर्फ उसी class के sections निकालो जिनका class_id इस class के बराबर है
            $classSections = $allot->subSections->where('class_id', $class->id);

            $sectionList = $classSections->map(function ($section) {
                return [
                    'section_name' => $section->section_name,
                    'students_count' => Crud::where('section_id', $section->id)->count(),
                ];
            })->values(); // reindex

            $classes->push([
                'class_name' => $class->class_name,
                'sections' => $sectionList,
            ]);

            $sections = $sections->merge($sectionList);
        }

        return response()->json([
            'teacher_name' => $teacherName,
            'total_classes' => $classes->count(),
            'total_sections' => $sections->count(),
            'total_students' => $sections->sum('students_count'),
            'classes' => $classes,
        ]);

    } catch (\Exception $e) {
        Log::error('Teacher allot show error: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to fetch data.'], 500);
    }
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $allot = TeacherAllotment::with(['teacher', 'mainClass', 'mainSection', 'subClasses', 'subSections'])
            ->findOrFail($id);

        return response()->json([
            'id' => $allot->id,
            'teacher_id' => $allot->teacher_id,
            'main_class_id' => $allot->main_class_id,
            'main_section_id' => $allot->main_section_id,
            'sub_class_ids' => $allot->subClasses->pluck('id')->toArray(),
            'sub_section_ids' => $allot->subSections->pluck('id')->toArray(),
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    // ✅ Validate request
    $request->validate([
        'teacher_id'      => 'required|exists:teacher_cruds,id',
        'main_class_id'   => 'required|exists:std_classes,id',
        'sub_class_ids'   => 'nullable|array',
        'main_section_id' => 'required|exists:sections,id',
        'sub_section_ids' => 'nullable|array',
    ]);

    $allotment = TeacherAllotment::findOrFail($id);

    // ✅ Check if this class + section is already allotted to another teacher
    $existingAllotment = TeacherAllotment::where('main_class_id', $request->main_class_id)
        ->where('main_section_id', $request->main_section_id)
        ->where('id', '!=', $id) // Ignore current allotment (because edit)
        ->first();

    if ($existingAllotment) {
        return response()->json([
            'status'  => 'error',
            'message' => 'This class and section is already allotted to another teacher.'
        ], 400);
    }

    // ✅ Update main fields
    $allotment->update([
        'teacher_id'      => $request->teacher_id,
        'main_class_id'   => $request->main_class_id,
        'main_section_id' => $request->main_section_id,
    ]);

    // ✅ Sync sub-classes (if any)
    $allotment->subClasses()->sync($request->sub_class_ids ?? []);

    // ✅ Sync sub-sections (if any)
    $subSections = collect($request->sub_section_ids)->flatten()->toArray();
    $allotment->subSections()->sync($subSections);

    // ✅ Return success response (for AJAX)
    return response()->json([
        'status'  => 'success',
        'message' => 'Teacher allotment updated successfully!'
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $allotment = TeacherAllotment::findOrFail($id);

            // ✅ Detach sub-classes and sub-sections relations
            $allotment->subClasses()->detach();
            $allotment->subSections()->detach();

            // ✅ Delete main record
            $allotment->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Teacher allotment deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}

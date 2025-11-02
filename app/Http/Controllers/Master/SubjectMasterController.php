<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Masters\SubjectMaster;
use Illuminate\Http\Request;
use App\Models\Masters\StdClass;
use Yajra\DataTables\Facades\DataTables;

class SubjectMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        if ($request->ajax()) {
            $query = SubjectMaster::select(['id', 'subject_name', 'max_marks', 'class_id'])->latest();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('class_name', function ($row) {
                    return $row->class ? $row->class->class_name : '-';
                })

                ->addColumn('actions', function ($row) {
                    return '<button data-id="' . $row->id . '" class="btn btn-sm btn-info subjectEditBtn me-1"><i class="fa fa-pencil"></i></button>' .
                        '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger subjectDeleteBtn"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['actions', 'class_name'])
                ->make(true);
        }
        return view('School_Dashboard.Admin_Pages.masters.subjectmaster', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    $data = $request->validate([
        'subject_name' => 'required',
        'class_id'     => 'required|exists:std_classes,id',
        'max_marks'    => 'required',
    ]);

    // ✅ Check if the subject is already allotted to this class
    $isExists = SubjectMaster::where('class_id', $data['class_id'])
                ->where('subject_name', $data['subject_name'])
                ->exists();

    if ($isExists) {
        return response()->json([
            'status'  => 'error',
            'message' => 'यह subject इस class को पहले ही allot किया जा चुका है!'
        ], 409); // 409 Conflict
    }

    // ✅ Create new subject if not exists
    $subjectMaster = SubjectMaster::create($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Subject Created Successfully',
        'subjectMaster' => $subjectMaster
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(SubjectMaster $subjectMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectMaster $subjectMaster, $id)
    {
        $subjectMaster = SubjectMaster::findOrFail($id);
        return response()->json($subjectMaster);
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    $subjectMaster = SubjectMaster::findOrFail($id);

    $data = $request->validate([
        'subject_name' => 'required',
        'class_id'     => 'required|exists:std_classes,id',
        'max_marks'    => 'required',
    ]);

    // ✅ Duplicate check: same class me same subject
    $duplicate = SubjectMaster::where('class_id', $data['class_id'])
                ->where('subject_name', $data['subject_name'])
                ->where('id', '!=', $id) // ignore current record
                ->exists();

    if ($duplicate) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Ye subject is class me already allot hai!'
        ], 409);
    }

    // Update if no duplicate
    $subjectMaster->update($data);

    return response()->json([
        'status' => 'Subject Updated Successfully',
        'subjectMaster' => $subjectMaster
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subjectMaster = SubjectMaster::findOrFail($id);
        $subjectMaster->delete();
        return response()->json([
            'status' => 'Subject Deleted Successfully'
        ]);
    }
}

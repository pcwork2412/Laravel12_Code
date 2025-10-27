<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SchoolMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SchoolMaster::select(['id', 'school_name', 'school_address', 'school_logo', 'school_tagline', 'school_session', 'school_principal_sign']);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('school_logo', function ($row) {
                    $src = $row->school_logo ? asset('storage/' . $row->school_logo) : '';
                    return '<img src="' . $src . '" style="width:80px; height:60px; object-fit:contain" class="rounded-circle" >';
                })
                ->addColumn('school_principal_sign', function ($row) {
                    $src = $row->school_principal_sign ? asset('storage/' . $row->school_principal_sign) : '';
                    return '<img src="' . $src . '" style="width:80px; height:60px; object-fit:contain" class="rounded-circle" >';
                })
                ->addColumn('actions', function ($row) {
                    return '<button data-id="' . $row->id . '" class="btn btn-sm btn-info schoolEditBtn me-1"><i class="fa fa-pencil"></i></button>' .
                        '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger schoolDeleteBtn"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['school_logo', 'school_principal_sign', 'actions'])
                ->make(true);
        }
        return view('School_Dashboard.Admin_Pages.masters.schoolmaster');
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
        'school_name' => 'required|string|max:255',
        'school_address' => 'required|string|max:255',
        'school_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'school_tagline' => 'required|string|max:255',
        'school_session' => 'required|regex:/^[0-9]{4}-[0-9]{4}$/',
        'school_principal_sign' => 'required|image|mimes:png|max:2048',
    ]);

    // ✅ Duplicate check
    $duplicate = SchoolMaster::where('school_name', $data['school_name'])->exists();
    if ($duplicate) {
        return response()->json([
            'status' => 'error',
            'message' => "School '{$data['school_name']}' already exists!"
        ], 409);
    }

    // ✅ File Uploads
    if ($request->hasFile('school_logo')) {
        $data['school_logo'] = $request->file('school_logo')->store('school_logo', 'public');
    }
    if ($request->hasFile('school_principal_sign')) {
        $data['school_principal_sign'] = $request->file('school_principal_sign')->store('school_principal_sign', 'public');
    }

    // ✅ Create school
    $schoolMaster = SchoolMaster::create($data);

    return response()->json([
        'status' => 'School Created Successfully',
        'schoolName' => $schoolMaster->school_name,
        'schoolMaster' => $schoolMaster
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(SchoolMaster $schoolMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolMaster $schoolMaster, $id)
    {
        $schoolMaster = SchoolMaster::findOrFail($id);
        return response()->json($schoolMaster);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, SchoolMaster $schoolMaster, $id)
{
    $data = $request->validate([
        'school_name'           => 'required|string|max:255',
        'school_address'        => 'required|string|max:255',
        'school_tagline'        => 'required|string|max:255',
        'school_session'        => 'required|regex:/^[0-9]{4}-[0-9]{4}$/',
        'school_logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'school_principal_sign' => 'nullable|image|mimes:png|max:2048',
    ]);

    $schoolMaster = SchoolMaster::findOrFail($id);

    // ✅ Duplicate check for school name (ignore current id)
    $duplicate = SchoolMaster::where('school_name', $data['school_name'])
                ->where('id', '!=', $id)
                ->exists();
    if ($duplicate) {
        return response()->json([
            'status' => 'error',
            'message' => "School '{$data['school_name']}' already exists!"
        ], 409);
    }

    // ✅ Logo update
    if ($request->hasFile('school_logo')) {
        if ($schoolMaster->school_logo && Storage::disk('public')->exists($schoolMaster->school_logo)) {
            Storage::disk('public')->delete($schoolMaster->school_logo);
        }
        $data['school_logo'] = $request->file('school_logo')->store('school_logo', 'public');
    }

    // ✅ Principal Sign update
    if ($request->hasFile('school_principal_sign')) {
        if ($schoolMaster->school_principal_sign && Storage::disk('public')->exists($schoolMaster->school_principal_sign)) {
            Storage::disk('public')->delete($schoolMaster->school_principal_sign);
        }
        $data['school_principal_sign'] = $request->file('school_principal_sign')->store('school_principal_sign', 'public');
    }

    // ✅ Update DB
    $schoolMaster->update($data);

    return response()->json([
        'status' => 'School Updated Successfully',
        'schoolMaster' => $schoolMaster
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolMaster $schoolMaster, $id)
    {
        $schlMaster = SchoolMaster::findOrFail($id);
        if ($schlMaster->school_logo && Storage::disk('public')->exists($schlMaster->school_logo)) {
            Storage::disk('public')->delete($schlMaster->school_logo);
        }
        if ($schlMaster->school_principal_sign && Storage::disk('public')->exists($schlMaster->school_principal_sign)) {
            Storage::disk('public')->delete($schlMaster->school_principal_sign);
        }
        $schlMaster->delete();
        return response()->json(['status' => 'School Deleted Successfully', 'schoolName' => $schlMaster->school_name], 200);
    }
}

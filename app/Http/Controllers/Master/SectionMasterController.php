<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models ;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use Illuminate\Http\Request;

class SectionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $classId = $request->get('class_id');

    if ($classId) {
        // Sirf ek class ke sections (aur unke student counts)
        $stdClasses = StdClass::with(['sections' => function($q) {
                            $q->withCount('students');
                        }])
                        ->where('id', $classId)
                        ->get();
    } else {
        // Sabhi classes (unke sections aur student count ke sath)
        $stdClasses = StdClass::with(['sections' => function($q) {
                            $q->withCount('students');
                        }])
                        ->get();
    }

    return view('School_Dashboard.Admin_Pages.masters.sectionmaster', compact('stdClasses', 'classId'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly  eated resource in storae.
     */
 public function store(Request $request)
{
    // 🔹 Step 1: Validation
    $request->validate([
        'class_id'         => 'required|exists:std_classes,id',
        'section_name'  => 'required|string|max:255',
    ]);

    // 🔹 Step 2: Duplicate check
    $sectionQuery = Section::where('section_name', $request->section_name)
        ->where('class_id', $request->class_id); // ✅ fixed column name (class_id)

    if ($request->id) {
        // Update ke time apne current record ko ignore karna
        $sectionQuery->where('id', '!=', $request->id);
    }

    if ($sectionQuery->exists()) {
        return response()->json([
            'status'  => 'error',
            'message' => "Section '{$request->section_name}' already exists in this class!"
        ], 409);
    }

      // 🔹 Step 3: Create new section
    $section = Section::create([
        'class_id'     => $request->class_id,
        'section_name' => $request->section_name,
    ]);


    // 🔹 Step 4: Return JSON response
    return response()->json([
        'status'  => 'success',
        'message' => $request->id 
            ? 'Section updated successfully!' 
            : 'Section added successfully!',
        'data'    => $section
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(   )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 
public function edit($id)
{
    $section = Section::find($id);

    if (!$section) {
        return response()->json(['error' => 'Section not found'], 404);
    }

    return response()->json($section);
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    // 🔹 Step 1: Validate request
    $request->validate([
        'section_name' => 'required|string|max:255',
        'class_id'        => 'required|exists:std_classes,id',
    ]);

    // 🔹 Step 2: Find section
    $section = Section::find($id);
    if (!$section) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Section not found!'
        ], 404);
    }

    // 🔹 Step 3: Check for duplicate section name in same class
    $exists = Section::where('section_name', $request->section_name)
        ->where('class_id', $request->class_id)
        ->where('id', '!=', $id)
        ->exists();

    if ($exists) {
        return response()->json([
            'status'  => 'error',
            'message' => "Section '{$request->section_name}' already exists in this class!"
        ], 409);
    }

    // 🔹 Step 4: Update record
    $section->update([
        'section_name' => $request->section_name,
        'class_id'     => $request->class_id,
    ]);

    // 🔹 Step 5: Return success response
    return response()->json([
        'status'  => 'success',
        'message' => 'Section updated successfully!',
        'data'    => $section,
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $section = Section::find($id);

    if (!$section) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Section not found!'
        ], 404);
    }

    $section->delete();

    return response()->json([
        'status'  => 'success',
        'message' => 'Section deleted successfully!'
    ]);
}

}

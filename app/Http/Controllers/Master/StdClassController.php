<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Masters\StdClass;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Log;

class StdClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stdClasses = StdClass::with('sections')
            ->orderBy('class_name', 'asc') // 🔹 ASC = ascending order (A → Z)
            ->get();
        return view('School_Dashboard.Admin_Pages.masters.class', compact('stdClasses'));
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


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'class_name' => 'required|string|max:255',
    //         'sections'   => 'required|array|min:1',
    //         'sections.*' => 'string|distinct',
    //     ]);

    //     // ✅ Duplicate check for class_name
    //     $classQuery = StdClass::where('class_name', $request->class_name);
    //     if ($request->id) {
    //         // Update: ignore current class id
    //         $classQuery->where('id', '!=', $request->id);
    //     }
    //     if ($classQuery->exists()) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => "Class '{$request->class_name}' already exists!"
    //         ], 409);
    //     }

    //     // Create or Update class
    //     $stdClass = StdClass::updateOrCreate(
    //         ['id' => $request->id],
    //         ['class_name' => $request->class_name]
    //     );

    //     if ($request->id) {
    //         // Update: delete old sections
    //         $stdClass->sections()->delete();
    //     }

    //     foreach ($request->sections as $sec) {
    //         $secName = trim($sec);

    //         // ✅ Duplicate check for sections of this class
    //         $exists = $stdClass->sections()->where('section_name', $secName)->exists();
    //         if (!$exists) {
    //             $stdClass->sections()->create([
    //                 'section_name' => $secName
    //             ]);
    //         }
    //     }

    //     $action = $request->id ? 'updated' : 'created';

    //     return response()->json([
    //         'status'   => 'success',
    //         'message'  => "Class '{$stdClass->class_name}' with sections has been $action successfully!",
    //         'class'    => $stdClass->load('sections')
    //     ]);
    // }
   public function store(Request $request)
{
    $request->validate([
        'class_name' => 'required|string|max:255',
    ]);

    // ✅ Duplicate check for class_name
    $exists = StdClass::where('class_name', $request->class_name)->exists();
    if ($exists) {
        return response()->json([
            'status'  => 'error',
            'message' => "Class '{$request->class_name}' already exists!"
        ], 409);
    }

    // 🔹 Create Class
    $stdClass = StdClass::create([
        'class_name' => $request->class_name
    ]);

    // 🔹 Create Default Section "A"
    $stdClass->sections()->create([
        'section_name' => 'A'
    ]);

    return response()->json([
        'status'   => 'success',
        'message'  => "Class '{$stdClass->class_name}' has been created successfully with default section 'A'!",
        'class'    => $stdClass
    ]);
}


    /**
     * Display the specified resource.
     */
   public function show($id)
{
    // 1️⃣ Class ke sath sections aur student count laiye
    $class = StdClass::with(['sections' => function ($q) {
        $q->withCount('students');
    }])->find($id);

    if (!$class) {
        return response()->json([
            'message' => 'Class not found!'
        ], 404);
    }

    // 2️⃣ Total students count (sum of all section counts)
    $totalStudents = $class->sections->sum('students_count');
    

    // 3️⃣ Return JSON response (AJAX ke liye)
    return response()->json([
        'class_name'     => $class->class_name,
        'total_sections' => $class->sections->count(),
        'total_students' => $totalStudents,
        'sections'       => $class->sections->map(function ($section) {
            return [
                'id'             => $section->id,
                'name'           => $section->section_name,
                'students_count' => $section->students_count,
            ];
        })
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $stdClass = StdClass::findOrFail($id);
    //     return response()->json($stdClass);
    // }

    public function edit($id)
    {
        $stdClass = StdClass::with('sections')->find($id);

        if (!$stdClass) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        return response()->json($stdClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'class_name' => 'required|string|max:255',
    ]);

    $stdClass = StdClass::find($id);
    if (!$stdClass) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Class not found!'
        ], 404);
    }

    // ✅ Duplicate check (ignore current id)
    $exists = StdClass::where('class_name', $request->class_name)
                       ->where('id', '!=', $id)
                       ->exists();

    if ($exists) {
        return response()->json([
            'status'  => 'error',
            'message' => "Class '{$request->class_name}' already exists!"
        ], 409);
    }

    // 🔹 Update class name
    $stdClass->update([
        'class_name' => $request->class_name
    ]);

    return response()->json([
        'status'   => 'success',
        'message'  => "Class '{$stdClass->class_name}' has been updated successfully!",
        'class'    => $stdClass
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $stdClass = StdClass::with('sections')->findOrFail($id);

            // ✅ Pehle related sections delete karo
            $stdClass->sections()->delete();

            // ✅ Fir class delete karo
            $stdClass->delete();

            return response()->json([
                'message' => "Class '{$stdClass->class_name}' and its sections deleted successfully!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete class: ' . $e->getMessage()
            ], 500);
        }
    }
}

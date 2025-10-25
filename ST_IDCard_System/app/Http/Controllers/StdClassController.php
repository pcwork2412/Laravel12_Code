<?php

namespace App\Http\Controllers;

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
        $stdClasses = StdClass::with('sections')->get();
        return view('masters.master', compact('stdClasses'));
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
    $request->validate([
        'class_name' => 'required|string|max:255',
        'sections'   => 'required|array|min:1',
        'sections.*' => 'string|distinct'
    ]);

    // ✅ Save or Update Class
    $stdClass = StdClass::updateOrCreate(
        ['id' => $request->id],
        ['class_name' => $request->class_name]
    );

    // ✅ Save Sections
    if ($request->id) {
        // Agar update ho raha hai, to purane sections delete karke naye save karo
        $stdClass->sections()->delete();
    }

    foreach ($request->sections as $sec) {
        $stdClass->sections()->create([
            'section_name' => trim($sec)
        ]);
    }

    $action = $request->id ? 'updated' : 'created';

    return response()->json([
        'message' => "Class '{$stdClass->class_name}' with sections has been $action successfully!",
        'class'   => $stdClass
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(StdClass $stdClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stdClass = StdClass::findOrFail($id);
        return response()->json($stdClass);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StdClass $stdClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
 */
public function destroy($id)
{
    $stdClass = StdClass::findOrFail($id);

    if (!$stdClass) {
        return response()->json([
            'message' => 'Class not found!'
        ], 404);
    }

    $stdClass->delete();

    return response()->json([
        'message' => 'Class deleted successfully!'
    ], 200);
}


}

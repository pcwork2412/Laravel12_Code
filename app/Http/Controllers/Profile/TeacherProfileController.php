<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeacherProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $teacher_id = Session::get('id');
        $teacher = TeacherCrud::find($teacher_id);

        return view('school_dashboard.teacher_pages.teacherprofile.teacherpro',compact('teacher'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('school_dashboard.teacher_pages.teacherprofile.teacherpro.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

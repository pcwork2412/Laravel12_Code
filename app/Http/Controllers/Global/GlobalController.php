<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Masters\Section;
use App\Models\Students\Crud;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
     public function getGlobalSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }

    public function getGlobalStudents($section_id)
    {
        $students = Crud::where('section_id', $section_id)->get();
        return response()->json($students);
    }
}

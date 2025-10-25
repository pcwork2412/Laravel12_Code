<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Masters\SubjectMaster;
use App\Models\Students\Crud;
use App\Models\Students\MarksAllotTable;
use App\Models\Teacher\TeacherAllotment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;

class MarksAllotTableController extends Controller
{

    public function getSubjects($class_id)
    {
        // SubjectMaster table me class_id ke basis par subjects fetch
        $subjects = SubjectMaster::where('class_id', $class_id)->get();
        return response()->json($subjects);
    }

    public function getSections($class_id)
    {
        $role = Session::get('role');
        if ($role === 'teacher') {
            $teacher_id = Session::get('id');
            // ✅ Step 2: Get teacher allotment
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
                ->where('teacher_id', $teacher_id)
                ->first();
            if ($allotment) {
                $main_class_id = $allotment->main_class_id;
                $main_section_id = $allotment->main_section_id;
            } else {
                // Agar null ho to default values
                $main_class_id = null;
                $main_section_id = null;
            }
            $class_id = $main_class_id;
            $section_id = $main_section_id;
            $sections = Section::where('id', $section_id)->get();
            return response()->json($sections);
        } elseif ('admin' === 'admin') {
            $sections = Section::where('class_id', $class_id)->get();
            return response()->json($sections);
        }
    }

    public function getStudents($section_id)
    {
        $students = Crud::where('section_id', $section_id)->get();
        return response()->json($students);
    }
    // MarksController.php
    public function checkStudentMarks($student_id)
    {
        $exists = DB::table('marks_allot_tables') // अपनी marks allot table का नाम डालो
            ->where('student_id', $student_id)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'edit_url' => $student_id // मान लो आपके पास edit route है
        ]);
    }

    public function index(Request $request)
    {
        // Role nikal lo
        $role = Session::get('role'); // ya Auth::user()->role
        // dd($role);
        // ✅ Teacher case
        if ($role === 'teacher') {
 
            $teacher_id = Session::get('id');

            // ✅ Step 2: Get teacher allotment
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
                ->where('teacher_id', $teacher_id)
                ->first();
            if ($allotment) {
                $main_class_id = $allotment->main_class_id;
                $main_section_id = $allotment->main_section_id;
            } else {
                // Agar null ho to default values
                $main_class_id = null;
                $main_section_id = null;

                // Optional: redirect ya message
                return redirect()->back()->with('error', 'No class/section assigned to this teacher.');
            }
            // ✅ Step 3: Fetch students in this class & section
            $query = Crud::where('class_id', $main_class_id)
                ->where('section_id', $main_section_id)
                ->select(['id', 'student_name', 'student_uid', 'promoted_class_name', 'section']);


            if ($request->ajax()) {

                return DataTables::of($query)
                    ->addIndexColumn() // ✅ yeh line add karo
                    ->addColumn('class', function ($row) {
                        return $row->promoted_class_name . ' - ' . $row->section;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->marks->isNotEmpty()) {
                            return '<span class="btn btn-sm btn-success"><i class="fa-solid fa-user-check fas-1x me-2"></i>Allotted</span>';
                        } else {
                            return '<span class="btn btn-sm btn-danger"><i class="fa-solid fa-user-xmark  fa-1x me-2"></i>Not Allotted</span>';
                        }
                    })
                    ->addColumn('actions', function ($row) {
                        if ($row->marks->isNotEmpty()) {
                            return '
                   <button class="btn btn-sm btn-info viewMarksBtn" data-id="' . $row->id  . '">
                       <i class="fa fa-eye"></i>
                    </button>

                    <a href="' . route('marks.edit', $row->id) . '"  class="btn btn-sm btn-warning editMarksBtn" data-id="' . $row->id . '">
                        <i class="fa fa-pencil"></i>
                    </a>
                     <button class="btn btn-sm btn-primary deleteMarksBtn" data-id="' . $row->id  . '">
                       <i class="fa fa-trash"></i>
                    </button>
                     ';
                        } else {
                            return '
                         <a href="' . route('marks.allotNowBtn', $row->id) . '" 
                     class="btn btn-sm btn-success allotMarksBtn">
                     <i class="fa fa-circle-plus fa-1x me-1"></i> Allot Now
                         </a>
                        ';
                        }
                    })
                    ->rawColumns(['status', 'actions'])
                    ->make(true);
            }

            return view('School_Dashboard.Teacher_Pages.students.marksallot.index');
        }


        // ✅ DataTables AJAX request
        if ($request->ajax()) {
            $query = Crud::with('marks') // relation: Student hasMany MarksAllotTable
                ->select(['id', 'student_name', 'student_uid', 'promoted_class_name', 'section']);

            return DataTables::of($query)
                ->addIndexColumn() // ✅ yeh line add karo
                ->addColumn('class', function ($row) {
                    return $row->promoted_class_name . ' - ' . $row->section;
                })
                ->addColumn('status', function ($row) {
                    if ($row->marks->isNotEmpty()) {
                        return '<span class="btn btn-sm btn-success"><i class="fa-solid fa-user-check fas-1x me-2"></i>Allotted</span>';
                    } else {
                        return '<span class="btn btn-sm btn-danger"><i class="fa-solid fa-user-xmark  fa-1x me-2"></i>Not Allotted</span>';
                    }
                })
                ->addColumn('actions', function ($row) {
                    if ($row->marks->isNotEmpty()) {
                        return '
                   <button class="btn btn-sm btn-info viewMarksBtn" data-id="' . $row->id  . '">
                       <i class="fa fa-eye"></i>
                    </button>

                    <a href="' . route('marks.edit', $row->id) . '"  class="btn btn-sm btn-warning editMarksBtn" data-id="' . $row->id . '">
                        <i class="fa fa-pencil"></i>
                    </a>
                     <button class="btn btn-sm btn-primary deleteMarksBtn" data-id="' . $row->id  . '">
                       <i class="fa fa-trash"></i>
                    </button>
                     ';
                    } else {
                        return '
                         <a href="' . route('marks.allotNowBtn', $row->id) . '" 
                     class="btn btn-sm btn-success allotMarksBtn">
                     <i class="fa fa-circle-plus fa-1x me-1"></i> Allot Now
                         </a>
                        ';
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
        return view('School_Dashboard.Admin_Pages.students.marksallot.index');
    }

    public function allotNowBtn($student_id)
    {
        $student = Crud::with(['classModel.subjects', 'section'])
            ->findOrFail($student_id);

        // Student ka info
        $data = [
            'student_id'          => $student->id,
            'class_id'            => $student->class_id,
            'section_id'          => $student->section_id,
            'promoted_class_name' => $student->classModel->class_name,
            'section'             => $student->section,
            'student_name'        => $student->student_name,
            'student_uid'         => $student->student_uid,
        ];

        // Class ke subjects
        $subjects = $student->classModel->subjects; // Collection of subjects

        $role = Session::get('role');
        if ('admin' === 'admin') {
            $view = 'School_Dashboard.Admin_Pages.students.marksallot.allotnow';
        } elseif ($role === 'teacher') {
            $view = 'School_Dashboard.Teacher_Pages.students.marksallot.allotnow';
        }
        return view($view, compact('data', 'subjects'));
        // return view('School_Dashboard.Admin_Pages.students.marksallot.allotNow', compact('data', 'subjects'));

    }

    public function create()
    {
        // $students = Crud::all(); // sabhi students dropdown ke liye
        // $classes = StdClass::orderBy('class_name', 'asc')->get();

        $role = Session::get('role');
        if ($role === 'teacher') {
            $teacher_id = Session::get('id');

            // ✅ Step 2: Get teacher allotment
            $allotment = TeacherAllotment::with(['mainClass', 'mainSection'])
                ->where('teacher_id', $teacher_id)
                ->first();
            if ($allotment) {
                $main_class_id = $allotment->main_class_id;
                $main_section_id = $allotment->main_section_id;
            } else {
                // Agar null ho to default values
                $main_class_id = null;
                $main_section_id = null;

                // Optional: redirect ya message
                return redirect()->back()->with('error', 'No class/section assigned to this teacher.');
            }
            $classes = StdClass::where('id', $main_class_id)->get();
            $view = 'School_Dashboard.Teacher_Pages.students.marksallot.create';
        } elseif ('admin' === 'admin') {
            $classes = StdClass::orderBy('class_name', 'asc')->get();
            $view = 'School_Dashboard.Admin_Pages.students.marksallot.create';
        }
        return view($view, compact('classes'));
    }
    public function edit($student_id)
    {
        $role = Session::get('role');

        // student_id के हिसाब से सभी allot records लाना
        $marks = MarksAllotTable::where('student_id', $student_id)->get();

        if ($marks->isEmpty()) {
            return response()->json(['error' => 'No marks found for this student'], 404);
        }

        // JSON format तैयार करना
        $data = [
            'student_id' => $student_id,
            'student_name'   => $marks->first()->student->student_name ?? null, // assuming student relation
            'class_id'   => $marks->first()->student->class_id ?? null, // assuming student relation
            'section_id' => $marks->first()->student->section_id ?? null,
            'promoted_class_name'   => $marks->first()->student->promoted_class_name ?? null, // assuming student relation
            'section' => $marks->first()->student->section ?? null,
            'exam_type'  => $marks->first()->exam_type,
            'year'       => $marks->first()->year,
            'subjects'   => $marks->map(function ($m) {
                return [
                    'subject_name'   => $m->subject_name,
                    'max_marks'      => $m->max_marks,
                    'obtained_marks' => $m->obtained_marks,
                ];
            })->toArray(),
        ];
        if ($role === 'teacher') {
            return view('School_Dashboard.Teacher_Pages.students.marksallot.edit', compact('data'));
        } elseif ('admin' === 'admin') {
            return view('School_Dashboard.Admin_Pages.students.marksallot.edit', compact('data'));
        }

        // return view('School_Dashboard.Admin_Pages.students.marksallot.edit', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            // ✅ Validation rules
            $rules = [
                'student_id'       => 'required|exists:cruds,id',
                'subject_name'     => 'required|array|min:1',
                'subject_name.*'   => 'required|string|max:255',
                'max_marks'        => 'required|array|min:1',
                'max_marks.*'      => 'required|numeric|min:1',
                'obtained_marks'   => 'required|array|min:1',
                'obtained_marks.*' => 'required|numeric|min:0',
                'exam_type'        => 'required|string|max:100',
                'year'             => 'required|digits:4|integer|min:2000',
            ];

            // ✅ Custom messages
            $messages = [
                'student_id.required' => 'Please select a student.',
                'student_id.exists'   => 'The selected student is invalid.',

                'subject_name.required'   => 'At least one subject is required.',
                'subject_name.*.required' => 'Subject name cannot be empty.',

                'max_marks.*.required' => 'Max marks are required for each subject.',
                'max_marks.*.numeric'  => 'Max marks must be a number.',
                'max_marks.*.min'      => 'Max marks must be greater than 0.',

                'obtained_marks.*.required' => 'Obtained marks are required.',
                'obtained_marks.*.numeric'  => 'Obtained marks must be a number.',
                'obtained_marks.*.min'      => 'Obtained marks cannot be negative.',

                'exam_type.required' => 'Exam type is required (e.g. Final, Midterm).',
                'year.required'      => 'Year is required.',
                'year.digits'        => 'Year must be a 4-digit number.',
                'year.min'           => 'Year must be after 2000.',
            ];

            // ✅ Validate
            $validated = $request->validate($rules, $messages);
            $student = Crud::where('id', $validated['student_id'])
                ->with('marks')
                ->first(); // सिर्फ एक student चाहिए

            // ❌ अगर student को marks allot नहीं हुए
            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Student not found.'
                ], 404);
            }

            if ($student->marks->isNotEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Student {$student->student_name} Already marks allotted Try for another student."
                ], 400);
            }
            // ✅ Array size mismatch check
            if (
                count($request->subject_name) !== count($request->max_marks) ||
                count($request->subject_name) !== count($request->obtained_marks)
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops! For every subject, you need to provide both max marks and obtained marks.'
                ], 422);
            }

            // ✅ Insert Marks
            foreach ($request->subject_name as $key => $subject) {
                MarksAllotTable::create([
                    'student_id'     => $request->student_id,
                    'subject_name'   => $subject,
                    'max_marks'      => $request->max_marks[$key],
                    'obtained_marks' => $request->obtained_marks[$key],
                    'exam_type'      => $request->exam_type,
                    'year'           => $request->year,
                ]);
            }


            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => "Marks allotted successfully!",
                ], 200);
            } else {
                return redirect()->route('marks.index')->with('success', 'Marks allotted successfully!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Return validation errors
            // ✅ Validation errors handle
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please fix the following errors:',
                    'errors'  => $e->errors(), // array of errors
                ], 422);
            } else {
                // Laravel automatically flashes validation errors to session
                throw $e; // redirect back with errors automatically
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error occurred while allotting marks Please Contact us Developer.',
                'debug' => config('app.debug') ? $e->getMessage() : null, // सिर्फ debug mode में दिखेगा
            ], 500);
        }
    }

    public function update(Request $request, $student_id)
    {
        $rules = [
            'class_name'       => 'required|exists:std_classes,id',
            'section_id'       => 'required',
            'student_id'       => 'required|exists:cruds,id',
            'exam_type'        => 'required|string|max:50',
            'year'             => 'required|digits:4',
            'subject_name'     => 'required|array|min:1',
            'subject_name.*'   => 'required|string',
            'max_marks'        => 'required|array|min:1',
            'max_marks.*'      => 'required|numeric',
            'obtained_marks'   => 'required|array|min:1',
            'obtained_marks.*' => 'required|numeric|min:0',
        ];

        $messages = [
            // General fields
            'class_name.required'   => 'Please select a class.',
            'class_name.exists'     => 'The selected class does not exist.',
            'section_id.required'   => 'Please select a section.',
            'student_id.required'   => 'Student ID is required.',
            'student_id.exists'     => 'The selected student does not exist.',
            'exam_type.required'    => 'Exam type is required.',
            'exam_type.string'      => 'Exam type must be a valid text.',
            'exam_type.max'         => 'Exam type should not exceed 50 characters.',
            'year.required'         => 'Year is required.',
            'year.digits'           => 'Year must be a 4-digit number (e.g. 2025).',

            // Subjects
            'subject_name.required'   => 'Please add at least one subject.',
            'subject_name.array'      => 'Subjects must be in list format.',
            'subject_name.*.required' => 'Each subject name is required.',
            'subject_name.*.string'   => 'Each subject name must be valid text.',

            // Max Marks
            'max_marks.required'   => 'Please enter max marks for all subjects.',
            'max_marks.array'      => 'Max marks must be in list format.',
            'max_marks.*.required' => 'Max marks are required for each subject.',
            'max_marks.*.numeric'  => 'Max marks must be a number.',

            // Obtained Marks
            'obtained_marks.required'   => 'Please enter obtained marks for all subjects.',
            'obtained_marks.array'      => 'Obtained marks must be in list format.',
            'obtained_marks.*.required' => 'Obtained marks are required for each subject.',
            'obtained_marks.*.numeric'  => 'Obtained marks must be a number.',
            'obtained_marks.*.min'      => 'Obtained marks cannot be less than 0.',
        ];

        $validated = $request->validate($rules, $messages);


        // ✅ Delete previous marks for this student (overwrite old)
        MarksAllotTable::where('student_id', $student_id)->delete();

        // ✅ अब validated data से loop चलाएँ
        foreach ($validated['subject_name'] as $index => $subName) {
            MarksAllotTable::create([
                'student_id'     => $validated['student_id'],
                'subject_name'   => $subName,
                'max_marks'      => $validated['max_marks'][$index],
                'obtained_marks' => $validated['obtained_marks'][$index],
                'exam_type'      => $validated['exam_type'],
                'year'           => $validated['year'],
            ]);
        }

        return redirect()->route('marks.index')->with('success', 'Marks updated successfully!');
    }

    public function show($id)
    {
        $student = Crud::with('marks')->findOrFail($id);

        // ✅ बस student + उसके सारे marks JSON में भेज दो
        return response()->json([
            'status' => true,
            'student' => $student,
            'image' => $student->image ? asset('storage/' . $student->image) : null, // ✅ send image

        ]);
    }

    public function destroy($student_id)
    {
        try {
            $deletedRows = MarksAllotTable::where('student_id', $student_id)->delete();

            if ($deletedRows > 0) {
                return response()->json([
                    'status'  => true,
                    'message' => "All marks for this student have been deleted successfully!"
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "No marks found for this student!"
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => "Something went wrong while deleting!"
            ], 500);
        }
    }
}

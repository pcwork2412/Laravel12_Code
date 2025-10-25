<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use Illuminate\Http\Request;
use App\Models\Masters\StdClass;
use App\Models\Masters\Section;
use App\Models\Students\Crud;
use Barryvdh\Snappy\Facades\SnappyPdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SchoolIdCardController extends Controller
{
    public function classwiseIdForm()
    {
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        $sections = Section::select('section_name')->distinct()->pluck('section_name');
        return view('school_dashboard.admin_pages.students.idcard_print_form.idcard_form', compact('classes', 'sections'));
    }

    public function genIdCardClasswise(Request $request)
    {
        try {
            // ✅ Step 1: Validate input
            $request->validate([
                'class_name' => 'required|string',
                'section_name' => 'required|string',
                // 'action'     => 'required|in:preview,generate',
            ], [
                'class_name.required' => 'Please Select Any Class.',
                'section_name.required' => 'Please Select Any Section.',
                // 'action.required'     => 'Action देना जरूरी है।',
                // 'action.in'           => 'Action गलत है, केवल preview या generate चुनें।',
            ]);

            // ✅ Step 2: Template check
            // $template = $request->query('template');
            // if (empty($template)) {
            //     return back()->with('error', 'Template नहीं चुना गया!');
            // }


            // ✅ Step 3: Check if any students exist in this class
            $classStudents = Crud::where('class_id', $request->class_name)->get();

            if ($classStudents->isEmpty()) {
                return back()->with('error', 'No students found in this class.');
            }

            // ✅ Step 2: Check if students exist in this class & section
            $students = Crud::where('class_id', $request->class_name)
                ->where('section_id', $request->section_name)
                ->get();

            if ($students->isEmpty()) {
                return back()->with('error', 'This class has no students in the selected section.');
            }


            // Qr COde data 
            $data = [
                'student_uid' => $students->first()->student_uid,
                'student_name' => $students->first()->student_name,
                'promoted_class_name' => $students->first()->class_name,
                'section' => $students->first()->section_name,
                'gender' => $students->first()->gender,
                'dob' => $students->first()->dob,
                'mother_name' => $students->first()->mother_name,
                'father_name' => $students->first()->father_name,
                'father_mobile' => $students->first()->father_mobile,
                'present_address' => $students->first()->present_address,
            ];
            $qr = QrCode::size(200)->generate(json_encode($data));
            $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qr);
            // Principal Signature
            $schlMaster = SchoolMaster::first();
            function clImageToBase64($relativePath)
            {
                $fullPath = storage_path('app/public/' . $relativePath); // 👈 real path

                if (file_exists($fullPath)) {
                    $mime = strtolower(mime_content_type($fullPath));
                    return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
                }

                return null;
            }

            $schoolData = [
                'school_name'           => $schlMaster->first()->school_name,
                'school_address'        => $schlMaster->first()->school_address,
                'school_tagline'        => $schlMaster->first()->school_tagline,
                'school_session'        => $schlMaster->first()->school_session,
                'school_logo'           => clImageToBase64($schlMaster->school_logo),
                'school_principal_sign' => clImageToBase64($schlMaster->school_principal_sign),
            ];


            // ✅ Step 4: PDF Generate
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.students.idcard_print_form.pdf.card4', compact('students', 'base64Qr', 'schoolData'))
                ->setOption('page-size', 'A4')
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('print-media-type', true)
                ->setOption('enable-local-file-access', true)
                ->setOption('dpi', 400)
                ->setOption('image-dpi', 400)
                ->setOption('image-quality', 100)
                ->setOption('footer-right', '[page] of [toPage]');

            // ✅ Step 5: Action handle
            if ($request->action === 'preview') {
                return $pdf->stream('id_cards.pdf');
            } elseif ($request->action === 'generate') {
                return $pdf->download('id_cards.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Form validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Unknown error (fallback)
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function singleIdForm()
    {

        $sections = Section::select('section_name')->distinct()->pluck('section_name');
        $classes = StdClass::orderBy('class_name', 'asc')->get();
        return view('school_dashboard.admin_pages.students.idcard_print_form.singleidform', compact('classes', 'sections'));
    }
    public function genIdCardSingle(Request $request)
    {
        try {
            // ✅ Step 1: Validate inputs
            $request->validate([
                'student_uid' => 'required|string|exists:cruds,student_uid',
                'class_name'  => 'required|string',
                'section_name' => 'required|string',
                'action'      => 'required|in:preview,generate',
            ], [
                'student_uid.required' => 'Student UID is required.',
                'student_uid.exists'   => 'This UID does not exist in records.',
                'class_name.required'  => 'Class name is required.',
                'section_name.required' => 'Section name is required.',
                'action.required'      => 'please select Action.',
                'action.in'            => 'please select a valid Action.',
            ]);


            // ✅ Step 2: Fetch student
            $students = Crud::where('student_uid', $request->student_uid)
                ->where('class_id', $request->class_name)
                ->where('section_id', $request->section_name) // yaha section_name match hoga
                ->get();

            if ($students->isEmpty()) {
                if (!Crud::where('student_uid', $request->student_uid)->exists()) {
                    return back()->with('error', '❌ Student UID not found.')->withInput();
                }

                if (!Crud::where('student_uid', $request->student_uid)
                    ->where('class_id', $request->class_name)->exists()) {
                    return back()->with('error', '❌ This UID does not belong to the selected class.')->withInput();
                }

                if (!Crud::where('student_uid', $request->student_uid)
                    ->where('class_id', $request->class_name)
                    ->where('section_id', $request->section_name)->exists()) {
                    return back()->with('error', '❌ This UID not found in the selected section.')->withInput();
                }
            }
            // Qr COde data 
            $data = [
                'student_uid' => $students->first()->student_uid,
                'student_name' => $students->first()->student_name,
                'promoted_class_name' => $students->first()->class_name,
                'section' => $students->first()->section_name,
                'gender' => $students->first()->gender,
                'dob' => $students->first()->dob,
                'mother_name' => $students->first()->mother_name,
                'father_name' => $students->first()->father_name,
                'father_mobile' => $students->first()->father_mobile,
                'present_address' => $students->first()->present_address,
            ];
            $qr = QrCode::size(200)->generate(json_encode($data));
            $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qr);
            // Principal Signature
            $schlMaster = SchoolMaster::first();
            function singImageToBase64($relativePath)
            {
                $fullPath = storage_path('app/public/' . $relativePath); // 👈 real path

                if (file_exists($fullPath)) {
                    $mime = strtolower(mime_content_type($fullPath));
                    return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
                }

                return null;
            }

            $schoolData = [
                'school_name'           => $schlMaster->school_name,
                'school_address'        => $schlMaster->school_address,
                'school_tagline'        => $schlMaster->school_tagline,
                'school_session'        => $schlMaster->school_session,
                'school_logo'           => singImageToBase64($schlMaster->school_logo),
                'school_principal_sign' => singImageToBase64($schlMaster->school_principal_sign),
            ];



            // ✅ Step 3: Generate PDF
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.students.idcard_print_form.pdf.card4', compact('students', 'base64Qr', 'schoolData'))
                ->setOption('page-size', 'A4')
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('print-media-type', true)
                ->setOption('enable-local-file-access', true)
                ->setOption('dpi', 400)
                ->setOption('image-dpi', 400)
                ->setOption('image-quality', 100)
                ->setOption('footer-right', '[page] of [toPage]');
            // ->setOption('disable-smart-shrinking', true)

            // ✅ Step 4: Handle action
            if ($request->action === 'preview') {
                return $pdf->stream('id_card.pdf');
            } elseif ($request->action === 'generate') {
                return $pdf->download('single_id_card.pdf');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Form validation error
            $messages = collect($e->errors())->flatten()->implode("\n");
            return back()->with('error', $messages)->withInput();
        } catch (\Exception $e) {
            // Unknown error (fallback)
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    // public function idCardTemplate()
    // {
    //     return view('students.idcard_template.templates');
    // }

    // public function templateSet(Request $request)
    // {
    //     $path = $request->input('template_path');

    //     // Sirf relative path nikalna (domain ke bina)
    //     $path = str_replace(url('/') . '/', '', $path);
    //     // Ab $path me relative path hoga, jaise 'pos/assets/img/flags/de.png'
    //     // dd($path);
    //     return redirect()->route('students.generateid', ['template' => $path]);
    // }
}

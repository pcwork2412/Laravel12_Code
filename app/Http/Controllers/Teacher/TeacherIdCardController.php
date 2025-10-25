<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Masters\SchoolMaster;
use App\Models\Teacher\TeacherCrud;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

class TeacherIdCardController extends Controller
{
    public function allIdCardForm()
    {
        return view('school_dashboard.admin_pages.teachers.idcard_print_form.idcard_form');
    }
    public function genIdAll(Request $request)
    {
        try {
            $teachers = TeacherCrud::all();
            if ($teachers->isEmpty()) {
                return back()->with('error', 'No Teacher found!');
            }

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
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.teachers.idcard_print_form.pdf.card4', compact('teachers', 'schoolData'))
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
        return view('school_dashboard.admin_pages.teachers.idcard_print_form.singleidform');
    }
    public function genIdCardSingle(Request $request)
    {
        try {
            // ✅ Step 1: Validate inputs
            $request->validate([
                'teacher_id'  => 'required|string|exists:teacher_cruds,teacher_id',
                'action'      => 'required|in:preview,generate',
            ], [
                'teacher_id.required' => 'Student UID is required.',
                'teacher_id.exists'   => 'This UID does not exist in records.',
                'action.required'      => 'please select Action.',
                'action.in'            => 'please select a valid Action.',
            ]);


            // ✅ Step 2: Fetch student
            $teachers = TeacherCrud::where('teacher_id', $request->teacher_id)->get();

            if ($teachers->isEmpty()) {
                if (!TeacherCrud::where('teacher_id', $request->teacher_id)->exists()) {
                    return back()->with('error', '❌ Student UID not found.')->withInput();
                }
            }
      
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
            $pdf = SnappyPdf::loadView('school_dashboard.admin_pages.teachers.idcard_print_form.pdf.card4', compact('teachers', 'schoolData'))
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
}

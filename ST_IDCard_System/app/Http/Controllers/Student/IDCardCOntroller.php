<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;

class IDCardCOntroller extends Controller
{
    public function generateIdForm()
    {
        $classes = StdClass::all();
        return view('students.idcard_form', compact('classes'));
    }

   public function generateId(Request $request)
{
    try {
        // ✅ Step 1: Validate input
        $request->validate([
            'class_name' => 'required|string',
            // 'action'     => 'required|in:preview,generate',
        ], [
            'class_name.required' => 'Please Select Any Class.',
            // 'action.required'     => 'Action देना जरूरी है।',
            // 'action.in'           => 'Action गलत है, केवल preview या generate चुनें।',
        ]);

        // ✅ Step 2: Template check
        // $template = $request->query('template');
        // if (empty($template)) {
        //     return back()->with('error', 'Template नहीं चुना गया!');
        // }

        // ✅ Step 3: Students fetch
        $students = Crud::where('class_name', $request->class_name)->get();
        if ($students->isEmpty()) {
            return back()->with('error', 'No student found in this class!');
        }

        // ✅ Step 4: PDF Generate
        $pdf = SnappyPdf::loadView('Students.Pdf.IDCards.card1', compact('students'))
            ->setOption('page-size', 'A4')
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8')
            ->setOption('dpi', 300)
            ->setOption('zoom', 1.25)
            ->setOption('print-media-type', true)
            ->setOption('image-dpi', 72)
            ->setOption('image-quality', 100);

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
        $classes = StdClass::all();
        return view('students.singleIdForm', compact('classes'));
    }
  public function singleIdcard(Request $request)
{
    try {
        // ✅ Step 1: Validate inputs
        $request->validate([
            'student_uid' => 'required|string',
            'class_name'  => 'required|string',
            'action'      => 'required|in:preview,generate',
        ], [
            'student_uid.required' => 'please enter Student UID.',
            'class_name.required'  => 'please select Class.',
            'action.required'      => 'please select Action.',
            'action.in'            => 'please select a valid Action.',
        ]);

        // ✅ Step 2: Fetch student
        $students = Crud::where('student_uid', $request->student_uid)
            ->where('class_name', $request->class_name)
            ->get();

        if ($students->isEmpty()) {
            return back()->with('error', ' No student found with this UID in the selected class.')->withInput();
        }

        // ✅ Step 3: Generate PDF
        $pdf = SnappyPdf::loadView('Students.Pdf.IDCards.card1', compact('students'))
            ->setOption('page-size', 'A4')
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8')
            ->setOption('dpi', 300)
            ->setOption('zoom', 1.25)
            ->setOption('print-media-type', true)
            ->setOption('image-dpi', 72)
            ->setOption('image-quality', 100);

        // ✅ Step 4: Handle action
        if ($request->action === 'preview') {
            return $pdf->stream('single_id_card.pdf');
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


    public function idCardTemplate()
    {
        return view('students.idcard_template.templates');
    }

    public function templateSet(Request $request)
    {
        $path = $request->input('template_path');

        // Sirf relative path nikalna (domain ke bina)
        $path = str_replace(url('/') . '/', '', $path);
        // Ab $path me relative path hoga, jaise 'pos/assets/img/flags/de.png'
        // dd($path);
        return redirect()->route('students.generateid', ['template' => $path]);
    }
}

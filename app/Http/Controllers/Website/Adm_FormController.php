<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Barryvdh\DomPDF\Facade\Pdf;

class Adm_FormController extends Controller
{
    public function admissionFormPdf()
{
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('web_pages.web_all_pages.admission.pdf.admission_form_pdf');

    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="admission_form.pdf"');
}

}

<?php

namespace App\Exports;

use App\Models\Students\Crud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Crud::select('student_name', 'promoted_class_name', 'section', 'father_name', 'father_mobile')->get();
    }

    public function headings(): array
    {
        return ['Student Name', 'Class', 'Section', 'Father Name', 'Mobile'];
    }
}

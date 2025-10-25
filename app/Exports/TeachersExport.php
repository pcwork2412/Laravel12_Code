<?php

namespace App\Exports;

use App\Models\Teacher\TeacherCrud as TeacherTeacherCrud;
use App\Models\TeacherCrud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TeachersExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TeacherTeacherCrud::select('teacher_name', 'email', 'mobile', 'address', 'qualification')->get();
    }
     public function headings(): array
    {
        return ['Teacher Name', 'Email ID', 'Mobile', 'Address', 'Qualifications'];
    }
}

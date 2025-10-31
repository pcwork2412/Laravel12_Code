<?php

namespace App\Exports;

use App\Models\Students\Crud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    // public function collection()
    // {
    //     return Crud::select('student_name', 'promoted_class_name', 'section', 'father_name', 'father_mobile')->get();
    // }

    // public function headings(): array
    // {
    //     return ['Student Name', 'Class', 'Section', 'Father Name', 'Mobile'];
    // }
      protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Crud::select($this->fields)->get();
    }

    public function headings(): array
    {
        return array_map(function($field) {
            return ucwords(str_replace('_', ' ', $field));
        }, $this->fields);
    }
}

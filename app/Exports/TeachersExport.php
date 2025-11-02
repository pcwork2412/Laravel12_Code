<?php

namespace App\Exports;

use App\Models\Teacher\TeacherCrud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromCollection, WithHeadings
{
    protected $fields;
    protected $teacherIds;

    public function __construct(array $fields, array $teacherIds = [])
    {
        $this->fields = $fields;
        $this->teacherIds = $teacherIds;
    }

    public function collection()
    {
        $query = TeacherCrud::select($this->fields);
        
        if (!empty($this->teacherIds)) {
            $query->whereIn('id', $this->teacherIds);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return array_map(function($field) {
            return ucwords(str_replace('_', ' ', $field));
        }, $this->fields);
    }
}
<?php

namespace App\Exports;

use App\Models\Students\Crud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $fields;
    protected $studentIds;

    public function __construct(array $fields, array $studentIds = [])
    {
        $this->fields = $fields;
        $this->studentIds = $studentIds;
    }

    public function collection()
    {
        $query = Crud::select($this->fields);
        
        // Filter by student IDs if provided
        if (!empty($this->studentIds)) {
            $query->whereIn('id', $this->studentIds);
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
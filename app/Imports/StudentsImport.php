<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'code'     => $row['code'],
            'saint_name'    => $row['saint_name'],
            'first_name'    => $row['first_name'],
            'last_name'    => $row['last_name'],
            'class_id'    => $row['class_id'],
        ]);
    }
    public function collection()
    {
        return Student::all();
    }
}
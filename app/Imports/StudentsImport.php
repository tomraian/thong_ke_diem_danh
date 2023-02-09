<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class StudentsImport implements ToModel, WithHeadingRow,WithValidation,SkipsOnFailure,SkipsOnError
{
    use Importable,SkipsErrors,SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
   

    public function model(array $row)
    {
        // $class = Classes::query()->where('name',$row['class_id'])->get()[0]->id;
        // dd( $row['code']);
        return new Student([
            'code'        =>  $row['code'],
            'tenthanh'    =>  $row['tenthanh'],
            'ho'          =>  $row['ho'],
            'ten'         =>  $row['ten'],
            // 'class_id'      => $row['class_id'],
            'class_id'    => Classes::query()->where('name',$row['class_id'])->get()[0]->id,
        ]);
    }
    public function collection()
    {
        return Student::all();
    }
 
    public function rules() :array{
        return[
            '*.code' => ['required','unique:students,code'],
            '*.ho' => ['required'],
            '*.ten' => ['required'],
            '*.class_id' => ['required'],
        ];
    }
}
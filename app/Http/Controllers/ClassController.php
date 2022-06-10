<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ClassesImport;
use App\Models\Classes;
use Maatwebsite\Excel\Facades\Excel;

class ClassController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importView()
    {
        return view('classes.import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        Excel::import(new ClassesImport, $request->file);

        return back()->with('success', 'Thêm lớp học thành công rồi đó!!!');
    }
    public function api(Request $request)
    {
        return Classes::query()
            ->where('name', 'like', '%' . $request->get('q') . '%')
            ->get([
                'id',
                'name',
            ]);
    }
}
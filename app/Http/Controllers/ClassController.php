<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ClassesImport;
use App\Models\Classes;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ClassController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importView(Request $request)
    {
        $orderBy = "";
        $count = Classes::query()->where('status',0)->count();
        if($request->orderby == null){
            $orderBy = "status";
        }
        else{
            $orderBy = $request->orderby;
        }
        $classes = Classes::query()->orderBy($orderBy, 'asc')->get();
        return view('classes.import', compact('classes','count'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:classes',
        ]);
        $class = new Classes();
        $class->fill($request->all());
        $class->save();
        return redirect()->back()->with('success', 'Thêm thành công');
    }
    public function status(Request $request,Classes $classes)
    {
        if($classes->status == 0){
            $classes->status = 1;
        }
        else{
            $classes->status = 0;
        }
        $classes->save();
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        Excel::import(new ClassesImport, $request->file);

        return back()->with('success', 'Thêm lớp học thành công rồi !!!');
    }
    public function api(Request $request)
    {
        return Classes::query()
            ->where('name', 'like', '%' . $request->get('q') . '%')
            ->Where('status', 0)
            ->get([
                'id',
                'name',
            ]);
    }
    public function destroy(Classes $classes)
    {
        $classes->delete();
        return back()->with('success', "Xóa lớp $classes->name thành công rồi !!!");
    }
    public function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Classes::query()->truncate();
        return redirect()->route('classes.importView')->with('success', 'Xóa tất cả các lớp thành công!!!!');
    }
}

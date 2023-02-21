<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use App\Helper\Helper;
use App\Models\Classes;
use App\Models\DayRequired;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dayRequired = DayRequired::query()->latest('id')->first();
        $start_date = Helper::correctDateTime(Attendance::min('date'))['date'];
        $end_date = Helper::correctDateTime(Attendance::max('date'))['date'];
        return view('student.index', compact('start_date', 'end_date', 'dayRequired'));
    }
    public function count()
    {
        $attendances = Attendance::select('student_code')->distinct()->get();
        foreach ($attendances as $attendance) {
            $check_isset_attendance_details = AttendanceDetail::query()->where('student_code', $attendance->student_code)->get();
            if (count($check_isset_attendance_details) == 0) {
                $count_sunday = Attendance::query()
                    ->select(DB::raw("SUM(count) as count"))
                    ->where('is_sunday', 1)
                    ->where('student_code', $attendance->student_code)
                    ->get();
                $count_not_sunday = Attendance::query()
                    ->select(DB::raw("SUM(count) as count"))
                    ->where('is_sunday', 0)
                    ->where('student_code', $attendance->student_code)
                    ->get();
                // dd($count_not_sunday[0]->count == null);
                $attendance_detail = new AttendanceDetail();
                $attendance_detail->student_code = $attendance->student_code;

                ($count_sunday[0]->count == null) ? $attendance_detail->count_sunday = 0 : $attendance_detail->count_sunday = $count_sunday[0]->count;
                ($count_not_sunday[0]->count == null) ? $attendance_detail->count_not_sunday = 0 : $attendance_detail->count_not_sunday = $count_not_sunday[0]->count;
                // $attendance_detail->count_sunday = $count_sunday[0]->count;
                // $attendance_detail->count_not_sunday = $count_not_sunday[0]->count;
                $attendance_detail->save();
            }
        }

        return redirect()->route('student.index');
    }
    public function api()
    {
        function dataAttendance($student, $day)
        {
            $data = $student->AttendanceDetails->first();
            if ($data == '' || $data == 'null') {
                return 0;
            } else {
                return $data->$day;
            }
        }
        $dayRequired = DayRequired::query()->latest('id')->first();
        return Datatables::of(Student::query()->with('class', 'AttendanceDetails'))
            ->editColumn('class_id', function ($student) {
                return $student->class->name;
            })
            ->editColumn('code', function ($student) {
                if (strlen($student->code) == 3) {
                    return "0" . $student->code;
                }
                return  $student->code;
            })
            ->addColumn('count_sunday', function ($student) {
                return dataAttendance($student, 'count_sunday');
            })
            ->addColumn('count_not_sunday', function ($student) {
                return dataAttendance($student, 'count_not_sunday');
            })
            ->addColumn('off_sunday', function ($student) use ($dayRequired) {
                $count_sunday = dataAttendance($student, 'count_sunday');
                $sunday_required = $dayRequired->sunday_required;
                if (($sunday_required - $count_sunday) <= -1) {
                    return 0;
                }
                return  $sunday_required - $count_sunday;
            })
            ->addColumn('off_not_sunday', function ($student) use ($dayRequired) {
                $count_not_sunday = dataAttendance($student, 'count_not_sunday');
                $not_sunday_required = $dayRequired->not_sunday_required;
                if (($not_sunday_required - $count_not_sunday) <= -1) {
                    return 0;
                }
                return $not_sunday_required - $count_not_sunday;
            })
            // ->filterColumn('name', function ($query, $keyword) {
            //     $query->whereHas('class', function ($q) use ($keyword) {
            //         return $q->where('name', $keyword);
            //     });
            // })
            ->make(true);
    }
    public function listApi()
    {
        return Datatables::of(Student::query()->with('class'))
            ->editColumn('class_id', function ($student) {
                return $student->class->name;
            })
            ->editColumn('code', function ($student) {
                if (strlen($student->code) == 3) {
                    return "0" . $student->code;
                }
                return  $student->code;
            })
            ->make(true);
    }

    public function list()
    {
        return view('student.list');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        return view('student.list');
    }

    public function importView()
    {
        return view('student.import');
    }
    public function import(Request $request)
    {
        // Excel::import(new StudentsImport, $request->file);
        $file = $request->file;
        $import = new StudentsImport();
        $import->import($file);
        // dd($import);
        // // dd($failures->row(),$failures->attribute(),$failures->errors(),$failures->values());
        if($import->failures()->isNotEmpty()){
            dd($import->failures()[0]);
        }
        return redirect()->route('student.importView')->with('success', 'Thêm thiếu nhi thành công rồi!!!!');
    }

    public function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Student::query()->truncate();
        return redirect()->route('student.importView')->with('success', 'Xóa danh sách thiếu nhi thành công!!!!');
    }
}

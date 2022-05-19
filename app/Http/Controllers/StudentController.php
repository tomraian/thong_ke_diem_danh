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

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start_date = Helper::correctDateTime(Attendance::min('date'))['date'];
        $end_date = Helper::correctDateTime(Attendance::max('date'))['date'];
        return view('student.index', compact('start_date', 'end_date'));
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
        return Datatables::of(Student::query()->orderBy('code', 'ASC')->with('class', 'AttendanceDetails'))
            ->editColumn('class_id', function ($student) {
                return $student->class->name;
            })
            ->addColumn('count_sunday', function ($student) {
                // return $student->AttendanceDetails;
                if ($student->AttendanceDetails->first() == '') {
                    return 0;
                } else {
                    return $student->AttendanceDetails->first()->count_sunday;
                }
            })
            ->addColumn('count_not_sunday', function ($student) {
                // return $student;
                if ($student->AttendanceDetails->first() == 'null' || $student->AttendanceDetails->first() == '') {
                    return 0;
                } else {
                    return $student->AttendanceDetails->first()->count_not_sunday;
                }
            })
            ->make(true);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importView()
    {
        return view('student.import');
    }
    public function import(Request $request)
    {
        Excel::import(new StudentsImport, $request->file);

        return redirect()->route('student.index')->with('success', 'Thêm thiếu nhi thành công rồi đó!!!');
    }

    public function truncate()
    {
        AttendanceDetail::query()->truncate();
        Attendance::query()->truncate();
        return redirect()->route('student.index')->with('success', 'xóa được rồi nè');
    }
}
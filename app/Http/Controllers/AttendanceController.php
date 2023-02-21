<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Student;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Imports\AttendancesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Helper\Helper;

class AttendanceController extends Controller
{
    public function __construct()
    {
    }
    // function correctDateTime($dateTime)
    // {
    //     # integer digits for Julian date
    //     $julDate = floor($dateTime);
    //     # The fractional digits for Julian Time
    //     $julTime = $dateTime - $julDate;
    //     # Converts to Timestamp
    //     $timeStamp = ($julDate > 0) ? ($julDate - 25569) * 86400 + $julTime * 86400 : $julTime * 86400;
    //     return [
    //         "date-time" => date("/-m/Y H:i:s", $timeStamp),
    //         "date" => date("d/m/Y", $timeStamp),
    //         "time" => date("H:i:s", $timeStamp)
    //     ];
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $attendances = Attendance::paginate(200);
        // dd($attendances);
        // return view('attendance.index', compact('attendances'));
        return view('attendance.index');
    }
    public function count()
    {
        $students = Attendance::all();
        foreach ($students as $student) {
            $i = 0;
            // $CN_1 = [
            //     'gio_vao' => 0.1875,
            //     'gio_ra' => 0.232638888888889
            // ];
            $CN_2 = [
                'gio_vao' => 0.270833333333333,
                'gio_ra' => 0.315972222
            ];
            // $CN_3 = [
            //     'gio_vao' => 0.625,
            //     'gio_ra' => 0.670138889
            // ];
            // $CN_4 = [
            //     'gio_vao' => 0.708333333333333,
            //     'gio_ra' => 0.753472222
            // ];
            // $NT_1 = [
            //     'gio_vao' => 0.166666666666667,
            //     'gio_ra' => 0.211805555555556
            // ];
            $NT_2 = [
                'gio_vao' => 0.697916666666667,
                'gio_ra' => 0.732638889,
            ];
            $time = [
                'time_1' => $student->time_1,
                'time_2' => $student->time_2,
                'time_3' => $student->time_3,
                'time_4' => $student->time_4,
            ];
            // $CN_1 = array_merge($CN_1, $time);
            $CN_2 = array_merge($CN_2, $time);
            // $CN_3 = array_merge($CN_3, $time);
            // $CN_4 = array_merge($CN_4, $time);
            // $NT_1 = array_merge($NT_1, $time);
            $NT_2 = array_merge($NT_2, $time);
            if ($student->is_sunday == 1) {
                // switch ($CN_1) {
                //     case ($CN_1['time_1'] >= $CN_1['gio_vao'] && $CN_1['time_1'] <= $CN_1['gio_ra']):
                //         $i = $i + 1;
                //         break;
                //     case $CN_1['time_2'] >= $CN_1['gio_vao'] && $CN_1['time_2'] <= $CN_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_1['time_3'] >= $CN_1['gio_vao'] && $CN_1['time_3'] <= $CN_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_1['time_4'] >= $CN_1['gio_vao'] && $CN_1['time_4'] <= $CN_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                // }
                switch ($CN_2) {
                    case $CN_2['time_1'] >= $CN_2['gio_vao'] && $CN_2['time_1'] <= $CN_2['gio_ra']:
                        $i = $i + 1;
                        break;
                    case $CN_2['time_2'] >= $CN_2['gio_vao'] && $CN_2['time_2'] <= $CN_2['gio_ra']:
                        $i = $i + 1;
                        break;
                    case $CN_2['time_3'] >= $CN_2['gio_vao'] && $CN_2['time_3'] <= $CN_2['gio_ra']:
                        $i = $i + 1;
                        break;
                    case $CN_2['time_4'] >= $CN_2['gio_vao'] && $CN_2['time_4'] <= $CN_2['gio_ra']:
                        $i = $i + 1;
                        break;
                }
                // switch ($CN_3) {
                //     case $CN_3['time_1'] >= $CN_3['gio_vao'] && $CN_3['time_1'] <= $CN_3['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_3['time_2'] >= $CN_3['gio_vao'] && $CN_3['time_2'] <= $CN_3['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_3['time_3'] >= $CN_3['gio_vao'] && $CN_3['time_3'] <= $CN_3['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_3['time_4'] >= $CN_3['gio_vao'] && $CN_3['time_4'] <= $CN_3['gio_ra']:
                //         $i = $i + 1;
                //         break;
                // }
                // switch ($CN_4) {
                //     case $CN_4['time_1'] >= $CN_4['gio_vao'] && $CN_4['time_1'] <= $CN_4['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_4['time_2'] >= $CN_4['gio_vao'] && $CN_4['time_2'] <= $CN_4['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_4['time_3'] >= $CN_4['gio_vao'] && $CN_4['time_3'] <= $CN_4['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $CN_4['time_4'] >= $CN_4['gio_vao'] && $CN_4['time_4'] <= $CN_4['gio_ra']:
                //         $i = $i + 1;
                //         break;
                // }
            } else {
                // switch ($NT_1) {
                //     case ($NT_1['time_1'] >= $NT_1['gio_vao'] && $NT_1['time_1'] <= $NT_1['gio_ra']):
                //         $i = $i + 1;
                //         break;
                //     case $NT_1['time_2'] >= $NT_1['gio_vao'] && $NT_1['time_2'] <= $NT_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $NT_1['time_3'] >= $NT_1['gio_vao'] && $NT_1['time_3'] <= $NT_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                //     case $NT_1['time_4'] >= $NT_1['gio_vao'] && $NT_1['time_4'] <= $NT_1['gio_ra']:
                //         $i = $i + 1;
                //         break;
                // }
                switch ($NT_2) {
                    case ($NT_2['time_1'] >= $NT_2['gio_vao'] && $NT_2['time_1'] <= $NT_2['gio_ra']):
                        $i = $i + 1;
                        break;
                    case $NT_2['time_2'] >= $NT_2['gio_vao'] && $NT_2['time_2'] <= $NT_2['gio_ra']:
                        $i = $i + 1;
                        break;
                    case $NT_2['time_3'] >= $NT_2['gio_vao'] && $NT_2['time_3'] <= $NT_2['gio_ra']:
                        $i = $i + 1;
                        break;
                    case $NT_2['time_4'] >= $NT_2['gio_vao'] && $NT_2['time_4'] <= $NT_2['gio_ra']:
                        $i = $i + 1;
                        break;
                }
            }
            $student->count = $i;
            $student->save();
        }
        return redirect()->route('student.calculate');
    }
    public function api()
    {
        return Datatables::of(Attendance::query()->with('student', 'student.class:id,name')->get())
            ->editColumn('is_sunday', function ($student) {
                if ($student->is_sunday == 1) {
                    return 'Chúa Nhật';
                }
                return 'Ngày thường';
            })
            ->editColumn('date', function ($student) {
                return Helper::correctDateTime($student->date)['date'];
            })
            ->editColumn('time_1', function ($student) {
                return Helper::correctDateTime($student->time_1)['time'];
            })
            ->editColumn('time_2', function ($student) {
                return Helper::correctDateTime($student->time_2)['time'];
            })
            ->editColumn('time_3', function ($student) {
                return Helper::correctDateTime($student->time_3)['time'];
            })
            ->editColumn('time_4', function ($student) {
                return Helper::correctDateTime($student->time_4)['time'];
            })
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreAttendanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
        // dd(1);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAttendanceRequest $request
     * @param \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function importView()
    {
        return view('attendance.import');
    }


    public function import(Request $request)
    {
        // Excel::import(new AttendancesImport, $request->file);
        // dd($AttendancesImport->import($file));

        $file = $request->file;
        $AttendancesImport = new AttendancesImport;
        $AttendancesImport->import($file);
        return redirect()->route('attendance.process');
    }
    public function truncate()
    {
        AttendanceDetail::query()->truncate();
        Attendance::query()->truncate();
        return redirect()->back()->with('success', 'Xóa dữ liệu điểm danh thành công!!!!');
    }
}

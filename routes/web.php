<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DayRequiredController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

Route::post('/ngay-bat-buoc', [DayRequiredController::class, 'store'])->name('dayrequired.store');

//  lớp 
Route::get('/lop', [ClassController::class, 'importView'])->name('classes.importView');;
Route::post('/lop', [ClassController::class, 'import'])->name('classes.import');
Route::post('/lop/them', [ClassController::class, 'store'])->name('classes.store');
Route::post('/lop/cap-nhap-trang-thai-lop/{classes}', [ClassController::class, 'status'])->name('classes.status');
Route::post('/lop/xoa/{classes}', [ClassController::class, 'destroy'])->name('classes.destroy');
Route::get('/lop/api', [ClassController::class, 'api'])->name('classes.api');
Route::post('/lop/truncate', [ClassController::class, 'truncate'])->name('classes.truncate');

//  thiếu nhi 
Route::get('/', [StudentController::class, 'index'])->name('student.index');
Route::get('/api', [StudentController::class, 'api'])->name('student.api');
Route::get('/thieu-nhi', [StudentController::class, 'importView'])->name('student.importView');
Route::post('/thieu-nhi', [StudentController::class, 'import'])->name('student.import');
Route::post('/thieu-nhi/truncate', [StudentController::class, 'truncate'])->name('student.truncate');

Route::get('/danh-sach', [StudentController::class, 'list'])->name('student.list');
Route::get('/danh-sach/api', [StudentController::class, 'listApi'])->name('student.listApi');

Route::post('/sua/{student_id?}', [StudentController::class, 'update'])->name('student.update');

// điểm danh 

Route::get('/diem-danh', [AttendanceController::class, 'importView']);
Route::post('/diem-danh', [AttendanceController::class, 'import'])->name('attendance.import');

Route::get('/thong-ke/process', [AttendanceController::class, 'count'])->name('attendance.process');


Route::get('/thong-ke', [AttendanceController::class, 'index'])->name('attendance.index');


Route::get('/thong-ke/api', [AttendanceController::class, 'api'])->name('attendance.api');
Route::post('/diem-danh/truncate', [AttendanceController::class, 'truncate'])->name('attendance.truncate');

Route::get('/calculate', [StudentController::class, 'count'])->name('student.calculate');




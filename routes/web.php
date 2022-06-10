<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ClassController;
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
//  lớp 
Route::get('/lop', [ClassController::class, 'importView']);
Route::post('/lop', [ClassController::class, 'import'])->name('classes.import');
Route::get('/api/lop', [ClassController::class, 'api'])->name('classes.api');

//  thiếu nhi 
Route::get('/', [StudentController::class, 'index'])->name('student.index');
Route::get('/api', [StudentController::class, 'api'])->name('student.api');
Route::get('/thieu-nhi', [StudentController::class, 'importView']);
Route::post('/thieu-nhi', [StudentController::class, 'import'])->name('student.import');

// điểm danh 

Route::get('/diem-danh', [AttendanceController::class, 'importView']);
Route::post('/diem-danh', [AttendanceController::class, 'import'])->name('attendance.import');

Route::get('/thong-ke/process', [AttendanceController::class, 'count'])->name('attendance.process');


Route::get('/thong-ke', [AttendanceController::class, 'index'])->name('attendance.index');


Route::get('/thong-ke/api', [AttendanceController::class, 'api'])->name('attendance.api');



Route::get('/calculate', [StudentController::class, 'count'])->name('student.calculate');



Route::post('/truncate', [StudentController::class, 'truncate'])->name('student.truncate');
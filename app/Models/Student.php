<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'saint_name',
        'first_name',
        'last_name',
        'class_id',
    ];
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_code', 'code');
    }
    public function AttendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class, 'student_code', 'code');
    }
}
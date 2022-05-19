<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_code',
        'count_sunday',
        'count_not_sunday',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Attendance extends Model
{
    use HasFactory;
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }
    protected $fillable = [
        'student_code',
        'date',
        'is_sunday',
        'time_1',
        'time_2',
        'time_3',
        'time_4',
        'count',
    ];
    public function correctDateTime($dateTime)
    {
        # integer digits for Julian date
        $julDate = floor($dateTime);
        # The fractional digits for Julian Time
        $julTime = $dateTime - $julDate;
        # Converts to Timestamp
        $timeStamp = ($julDate > 0) ? ($julDate - 25569) * 86400 + $julTime * 86400 : $julTime * 86400;
        return [
            "date-time" => date("/-m/Y H:i:s", $timeStamp),
            "date" => date("d/m/Y", $timeStamp),
            "time" => date("H:i:s", $timeStamp)
        ];
    }
    // public function getTime1Attribute($value)
    // {
    //     return $this->correctDateTime($value)['time'];
    // }
    // public function getTime2Attribute($value)
    // {
    //     return $this->correctDateTime($value)['time'];
    // }
    // public function getTime3Attribute($value)
    // {
    //     return $this->correctDateTime($value)['time'];
    // }
    // public function getTime4Attribute($value)
    // {
    //     return $this->correctDateTime($value)['time'];
    // }
    // public function getIsSundayAttribute($value)
    // {
    //     if ($value == 1) {
    //         return 'Chúa Nhật';
    //     }
    //     return 'Ngày thường';
    // }
}
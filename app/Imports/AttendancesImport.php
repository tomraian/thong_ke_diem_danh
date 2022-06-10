<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class AttendancesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $thu = $row['thu'];
        if ($thu == 'CN') {
            $thu = 1;
        } else {
            $thu = 0;
        }
        // ini_set('memory_limit', '-1');
        return new Attendance([
            'student_code' => $row['ma'],
            'date' => $row['ngay'],
            'is_sunday' => $thu,
            'time_1' => "0" . substr($row['1'], 5),
            'time_2' => "0" . substr($row['2'], 5),
            'time_3' => "0" . substr($row['3'], 5),
            'time_4' => "0" . substr($row['4'], 5),
        ]);
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
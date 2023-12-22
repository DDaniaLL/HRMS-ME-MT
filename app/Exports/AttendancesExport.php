<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'ID',
            'Staff Name',
            'Year',
            'Month',

            'Date',
            'Day',
            'Start Hour',
            'End Hour',

            'Comment',
            'Leave/Overtime ID',
            'Status',
            'Line Manager',

        ];
    }

    public function collection()
    {
        return Attendance::where('id', '>=', '13')->get();
    }

    public function map($attendnace): array
    {
        return [
            $attendnace->id,
            isset($attendnace->user->name) ? $attendnace->user->name : $attendnace->user_id,
            $attendnace->year,
            $attendnace->month,

            $attendnace->day,
            $attendnace->sign,
            $attendnace->start_hour,
            $attendnace->end_hour,

            $attendnace->remarks,
            $attendnace->leave_overtime_id,
            $attendnace->status,
            isset($attendnace->user->linemanager) ? $attendnace->user->linemanager : $attendnace->user_id,

        ];
    }
}

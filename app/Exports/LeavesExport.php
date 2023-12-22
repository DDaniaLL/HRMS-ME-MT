<?php

namespace App\Exports;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeavesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $leaves;

    public function __construct($leaves)
    {

        $this->leaves = $leaves;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'People ID',
            'Leave ID',
            'Requester',
            'Office',
            'Leave Type',
            'Start Date',
            'End Date',
            'Days',
            'Reason',
            'Leave Status',
            'Line Manager (who approved)',
            'Line Manager Comment',
            'HR Focal point (who approved)',
            'HR Comment',
            'Extra Approver',
            'Extra Approver Comment',
            'Date Requested',
        ];
    }

    public function collection()
    {
        return $this->leaves;

        //     $hruser = Auth::user();
        //     if ($hruser->office == "CO-Erbil")
        //     {
        //         return Leave::all();

        //     }
        //     else
        //     $staffwithsameoffice = User::where('office',$hruser->office)->get();
        //         if (count($staffwithsameoffice))
        //         {
        //             $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
        //                 return collect($staffwithsameoffice->toArray())
        //                     ->only(['id'])
        //                     ->all();
        //             });
        //             return Leave::wherein('user_id', $hrsubsets)->get();

        // }
    }

    public function map($leave): array
    {
        return [
            $leave->user->employee_number,
            $leave->id,
            $leave->user->name,
            $leave->user->office,
            $leave->leavetype->name,
            $leave->start_date,
            $leave->end_date,
            $leave->days,
            $leave->reason,
            $leave->status,
            $leave->lmapprover,
            $leave->lmcomment,
            $leave->hrapprover,
            $leave->hrcomment,
            $leave->exapprover,
            $leave->excomment,
            $leave->created_at,

        ];
    }
}

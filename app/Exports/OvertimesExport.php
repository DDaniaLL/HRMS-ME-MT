<?php

namespace App\Exports;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OvertimesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $overtimes;

    public function __construct($overtimes)
    {

        $this->overtimes = $overtimes;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->overtimes;

        //     $hruser = Auth::user();
        //     if ($hruser->office == "CO-Erbil")
        //     {
        //         return Overtime::all();

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
        //             return Overtime::wherein('user_id', $hrsubsets)->get();

        // }
    }

    public function headings(): array
    {
        return [
            'People ID',
            'Overtime ID',
            'Requester',
            'Office',
            'Overtime Type',
            'Date',
            'Start Hour',
            'End Hour',
            'Overtime Hours',
            'Overtime Hours (value)',
            'Reason',
            'Status',
            'Line Manager (who approved)',
            'Line Manager Comment',
            'HR Focal point (who approved)',
            'HR Comment',
            'Extra Approver',
            'Extra Approver Comment',
            'Date Requested',
        ];
    }

    public function map($overtime): array
    {
        return [
            $overtime->user->employee_number,
            $overtime->id,
            $overtime->user->name,
            $overtime->user->office,
            $overtime->type,
            $overtime->date,
            $overtime->start_hour,
            $overtime->end_hour,
            $overtime->hours,
            $overtime->value,
            $overtime->status,
            $overtime->reason,
            $overtime->lmapprover,
            $overtime->lmcomment,
            $overtime->hrapprover,
            $overtime->hrcomment,
            $overtime->exapprover,
            $overtime->excomment,
            $overtime->created_at,
        ];
    }
}

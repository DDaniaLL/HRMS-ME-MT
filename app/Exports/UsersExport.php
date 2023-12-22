<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $users;

    public function __construct($users)
    {

        $this->users = $users;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->users;

        //     $hruser = Auth::user();
        //     if ($hruser->office == "CO-Erbil")
        //     {
        //         return User::all()->except(1);

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
        //             return User::wherein('id', $hrsubsets)->get();
        // }
    }

    public function map($user): array
    {
        return [

            $user->employee_number,
            $user->name,
            $user->office,
            $user->contract,
            $user->position,
            $user->department,
            $user->grade,
            $user->joined_date,
            $user->status,
            $user->linemanager,
            $user->hradmin,
            $user->email,
            $user->created_at,

        ];
    }

    public function headings(): array
    {
        return [

            'Employee Number',
            'Name',
            'office',
            'Contract',
            'Position',
            'Department',
            'Grade',
            'Joined Date',
            'Account Status',
            'Line Manager',
            'HR Admin',
            'Email',
            'Account Created Date',

        ];
    }
}

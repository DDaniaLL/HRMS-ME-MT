<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BalanceExport implements FromCollection, WithHeadings, WithMapping
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

        if ($user->contract == 'National') {
            return [

                $user->employee_number,
                $user->name,
                $user->position,
                $user->department,
                $user->office,
                $user->balances->first()->value, //'Annual',
                $user->balances->get(1)->value, // Sick SC
                $user->balances->get(2)->value, // Sick DC
                // $user->balances->get(3)->value,
                $user->balances->get(4)->value, // Marriage
                $user->balances->get(6)->value, // Compassioante
                $user->balances->get(7)->value, // Maternity
                $user->balances->get(8)->value, // Paternity
                $user->balances->get(9)->value, // Prilmiage
                $user->balances->get(17)->value, //  CTO
                $user->balances->get(22)->value, //  WFP
                // $user->balances->get(23)->value, //  Carry over


            ];
        } else
         {
            return [

                $user->employee_number,
                $user->name,
                $user->position,
                $user->department,
                $user->office,
                $user->balances->first()->value, //'Annual',
                $user->balances->get(10)->value, // R&R
                $user->balances->get(11)->value, // Home


            ];

        }

    }

    public function headings(): array
    {
        
        return [

            'Employee Number',
            'Name',
            'Position',
            'Departmenet',
            'Office',
            'Annual',
            'Sick SC / R&R',
            'Sick DC / Home leave',
            'Marriage',
            'Compassionate',
            'Maternity',
            'Paternity',
            'Pilgrimage',
            'CTO',
            'Work from home',
            'Carry over',

        ];
    }
}

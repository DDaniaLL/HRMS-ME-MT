<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'employee_number' => $row['employee'],
            'contract' => $row['contract'],
            'position' => $row['position'],
            'office' => $row['office'],
            'department' => $row['department'],
            'linemanager' => $row['linemanager'],
            'grade'=>$row['grade'],
            'hradmin' => $row['hradmin'],
            // 'superadmin' => $row['superadmin'],
            'joined_date' => Date::excelToDateTimeObject($row['joined']),
            'status' => $row['status'],
            'email' => $row['email'],
            'usertype_id' => $row['usertype'],
            'password' => Hash::make('password'),

        ]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\BalanceExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Mail\Balance as MailBalance;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\Office;
use App\Models\Overtime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $currentuser = Auth::user();
        if ($currentuser->office == 'NIAO') {
            $users = User::where('office', 'NIAO')->get();
            

            return view('admin.users.index', ['users' => $users, 'user' => $currentuser]);
        } elseif ($currentuser->office == 'KRAO') {
            $users = User::where('office', 'KRAO')->get();
            

            return view('admin.users.index', ['users' => $users, 'user' => $currentuser]);
        } elseif ($currentuser->office == 'CIAO') {
            $users = User::where('office', 'CIAO')->get();
            

            return view('admin.users.index', ['users' => $users, 'user' => $currentuser]);
        } elseif ($currentuser->office == 'SIAO') {
            $users = User::where('office', 'SIAO')->get();
            

            return view('admin.users.index', ['users' => $users, 'user' => $currentuser]);
        } else {
            $users = User::all()->except(1);
            return view('admin.users.index', ['users' => $users, 'user' => $currentuser]);
       
        }
    }

    public function create()
    {
        $users = User::all();
        $offices = Office::all();
        // dd($offices);
        $contract_enddate = date('Y-12-31');

        return view('admin.users.create', ['users' => $users, 'contract_enddate' => $contract_enddate,'offices'=>$offices]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'employee_number' => 'required|unique:users,employee_number',
            'contract' => 'required',
            'grade' => 'required',
            'position',
            'department',
            'office' => 'required',
            'joined_date' => 'required',
            // 'contract_enddate' => 'required',
            'linemanager',
            'hradmin',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        ]);

        // $user = User::create($request->validated());
        $user = new User();
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->contract = $request->contract;
        $user->position = $request->position;
        $user->office = $request->office;
        $user->office_id = Office::where('name',$request->office)->first()->id;
        $user->department = $request->department;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        $user->hradmin = $request->hradmin;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);

        $user->save();
        

        $year = date('Y', strtotime($user->joined_date));
        $day = date('d', strtotime($user->joined_date));
        $month = date('m', strtotime($user->joined_date));
        $datenow = Carbon::now();
        $yearnow = $datenow->year;

        // if ($user->contract == 'National') {
        //     if ($year < $yearnow) {
        //         $userannualleavebalance = '20';
        //     } else {

        //         if ($day < '15') {
        //             $userannualleavebalance = (1.67 * (12 - $month + 1));
        //         }

        //         else if ($day >= '15') {
        //             $userannualleavebalance = ((1.67 * (12 - $month)) + 0.5);
        //         }
        //     }
        // } else {

        //     if ($year < $yearnow) {
        //         $userannualleavebalance = '30';
        //     } else {

        //         if ($day < '15') {
        //             $userannualleavebalance = (2.5 * (12 - $month + 1));
        //         }

        //         else if ($day >= '15') {
        //             $userannualleavebalance = ((2.5 * (12 - $month)) + 0.5);
        //         }
        //     }
        // }
        // $annualleavehalfday = $userannualleavebalance * 2;

        $leavetypes = Leavetype::all();
        foreach ($leavetypes as $leavetype) {

            if ($leavetype->name == 'Annual leave' AND $leavetype->accrualtype == "monthly") {
                $user->balances()->create([

                    'name' => $leavetype->name,
                    'value' => 0,
                    'leavetype_id' => $leavetype->id,
                ]);

            } else {
                $user->balances()->create([
                    'name' => $leavetype->name,
                    'value' => $leavetype->value,
                    'leavetype_id' => $leavetype->id,
                ]);
            }
        }

        DB::table('users')->where('name', $request->linemanager)->update(['usertype_id' => '2']);

        $request->session()->flash('successMsg', trans('overtimeerror.createsuccess'));

        return redirect()->route('admin.users.show', $user);

    }

    public function show(User $user)
    {
        $hruser = Auth::user();
        $staff = User::where('linemanager', $user->name)->get();

        $leavetypes = Leavetype::where($user->contract,'yes')->pluck('name')->toArray();
        // dd($leaveypes);
        $balances = Balance::where('user_id', $user->id)->whereIn('name',$leavetypes)->get();
        // dd($balances);
        // $subsets = $balances->map(function ($balance) {
        //     return collect($balance->toArray())

        //         ->only(['name','value', 'leavetype_id'])
        //         ->all();
        // });
        // dd($balances);
            $leaves = Leave::where('user_id', $user->id)->with('user','leavetype')->get();
            $overtimes = Overtime::where('user_id', $user->id)->with('user')->get();

            return view('admin.users.show', [
                'user' => $user,
                'subsets'=>$balances,
                'leaves' => $leaves,
                'overtimes' => $overtimes,
                'employees' => $staff,
            ]);


        // if ($user->contract == 'International') {
        //     $balances = Balance::where('user_id', $user->id)->get();
        //     $subsets = $balances->map(function ($balance) {
        //         return collect($balance->toArray())

        //             ->only(['value', 'leavetype_id'])
        //             ->all();
        //     });

        //     //annual leave
        //     $leave1 = $subsets->firstwhere('leavetype_id', '1');
        //     $balance1 = round($leave1['value'], 3);

        //     //sick leave sc
        //     $leave4 = $subsets->firstwhere('leavetype_id', '4');
        //     $balance4 = round($leave4['value'], 3);

        //     //sick leave dc
        //     $leave7 = $subsets->firstwhere('leavetype_id', '7');
        //     $balance7 = round($leave7['value'], 3);

        //     //maternity leave
        //     $leave11 = $subsets->firstwhere('leavetype_id', '11');
        //     $balance11 = round($leave11['value'], 3);

        //     //paternity leave
        //     $leave12 = $subsets->firstwhere('leavetype_id', '12');
        //     $balance12 = round($leave12['value'], 3);

        //     //compassionate/welfare leave
        //     $leave13 = $subsets->firstwhere('leavetype_id', '13');
        //     $balance13 = round($leave13['value'], 3);

        //     //home leave
        //     $leave16 = $subsets->firstwhere('leavetype_id', '16');
        //     $balance16 = round($leave16['value'], 3);

        //     //work from home
        //     $leave22 = $subsets->firstwhere('leavetype_id', '22');
        //     $balance22 = round($leave22['value'], 3);

        //     //study leave
        //     $leave23 = $subsets->firstwhere('leavetype_id', '23');
        //     $balance23 = round($leave23['value'], 3);

        //     $leaves = Leave::where('user_id', $user->id)->get();
        //     $overtimes = Overtime::where('user_id', $user->id)->get();

        //     return view('admin.users.show', [
        //         'user' => $user,
        //         'balance1' => $balance1,
        //         'balance4' => $balance4,
        //         'balance7' => $balance7,
        //         'balance11' => $balance11,
        //         'balance12' => $balance12,
        //         'balance13' => $balance13,
        //         'balance16' => $balance16,
        //         'balance22' => $balance22,
        //         'balance23' => $balance23,
        //         'leaves' => $leaves,
        //         'overtimes' => $overtimes,
        //         'employees' => $staff,
        //     ]);
        // } else {
        //     $balances = Balance::where('user_id', $user->id)->get();
        //     $subsets = $balances->map(function ($balance) {
        //         return collect($balance->toArray())

        //             ->only(['value', 'leavetype_id'])
        //             ->all();
        //     });

        //     //annual leave
        //     $leave1 = $subsets->firstwhere('leavetype_id', '1');
        //     $balance1 = round($leave1['value'], 3);

        //     //sick leave sc
        //     $leave4 = $subsets->firstwhere('leavetype_id', '4');
        //     $balance4 = round($leave4['value'], 3);

        //     //sick leave dc
        //     $leave7 = $subsets->firstwhere('leavetype_id', '7');
        //     $balance7 = round($leave7['value'], 3);

        //     //marriage leave
        //     $leave10 = $subsets->firstwhere('leavetype_id', '10');
        //     $balance10 = round($leave10['value'], 3);

        //     //maternity leave
        //     $leave11 = $subsets->firstwhere('leavetype_id', '11');
        //     $balance11 = round($leave11['value'], 3);

        //     //paternity leave
        //     $leave12 = $subsets->firstwhere('leavetype_id', '12');
        //     $balance12 = round($leave12['value'], 3);

        //     //compassionate/welfare leave
        //     $leave13 = $subsets->firstwhere('leavetype_id', '13');
        //     $balance13 = round($leave13['value'], 3);

        //     //pilgiramge
        //     $leave14 = $subsets->firstwhere('leavetype_id', '14');
        //     $balance14 = round($leave14['value'], 3);

        //     //cto
        //     $leave20 = $subsets->firstwhere('leavetype_id', '20');
        //     $balance20 = round($leave20['value'], 3);

        //     //work from home
        //     $leave22 = $subsets->firstwhere('leavetype_id', '22');
        //     $balance22 = round($leave22['value'], 3);

        //     //study leave
        //     $leave23 = $subsets->firstwhere('leavetype_id', '23');
        //     $balance23 = round($leave23['value'], 3);

        //     //Illness leave
        //     $leave27 = $subsets->firstwhere('leavetype_id', '27');
        //     $balance27 = round($leave27['value'], 3);

        //     $leaves = Leave::where('user_id', $user->id)->get();
        //     $overtimes = Overtime::where('user_id', $user->id)->get();

        //     return view('admin.users.show', [
        //         'user' => $user,
        //         'balance1' => $balance1,
        //         'balance4' => $balance4,
        //         'balance7' => $balance7,
        //         'balance10' => $balance10,
        //         'balance11' => $balance11,
        //         'balance12' => $balance12,
        //         'balance13' => $balance13,
        //         'balance14' => $balance14,
        //         'balance20' => $balance20,
        //         'balance22' => $balance22,
        //         'balance23' => $balance23,
        //         'balance27' => $balance27,
        //         'leaves' => $leaves,
        //         'overtimes' => $overtimes,
        //         'employees' => $staff,
        //     ]);
        // }

    }

    public function edit(User $user)
    {
        $hruser = Auth::user();
        $userss = User::all();
        $hruser = Auth::user();

        return view('admin.users.edit', ['user' => $user,  'hruser' => $hruser, 'userss' => $userss]);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'employee_number' => 'required|unique:users,employee_number,'.$user->id,
            'contract',
            'position',
            'department',
            'grade' => 'required',
            'joined_date' => 'required',
            // 'contract_enddate' => 'required',
            'linemanager',
            'hradmin',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password',
        ]);

        $hruser = Auth::user();
        if ($user->joined_date !== $request->joined_date) {
            $mustchangeannual = '1';
        } elseif ($user->joined_date == $request->joined_date) {
            $mustchangeannual = '2';
        }

        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->contract = $request->contract;
        $user->position = $request->position;
        $user->department = $request->department;
        $user->grade = $request->grade;
        $user->linemanager = $request->linemanager;
        $user->joined_date = $request->joined_date;
        if ($hruser->superadmin == 'yes') {
            $user->hradmin = $request->hradmin;
        }

        $user->email = $request->email;

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $checkifuserhasleave = Leave::where([
            ['user_id', $user->id],
        ])->get();

        if ($checkifuserhasleave->isEmpty() && $mustchangeannual == '1') {

            $yearr = date('Y', strtotime($user->joined_date));
            $dayy = date('d', strtotime($user->joined_date));
            $monthh = date('m', strtotime($user->joined_date));
            $datenoww = Carbon::now();
            $yearnoww = $datenoww->year;

            if ($user->contract == 'National') {
                if ($yearr < $yearnoww) {
                    $userannualleavebalancee = '21';
                } else {
                    if ($dayy < '15') {
                        $userannualleavebalancee = (1.67 * (12 - $monthh + 1));
                    }
                    if ($dayy >= '15') {
                        $userannualleavebalancee = ((1.67 * (12 - $monthh)) + 0.5);
                    }
                }
            } else {
                if ($yearr < $yearnoww) {
                    $userannualleavebalancee = '30';
                } else {
                    if ($dayy < '15') {
                        $userannualleavebalancee = (2.5 * (12 - $monthh + 1));
                    }
                    if ($dayy >= '15') {
                        $userannualleavebalancee = ((2.5 * (12 - $monthh)) + 0.5);
                    }
                }
            }

            $annualleavehalfdayy = $userannualleavebalancee * 2;

            $user->balances()->where('name', 'Annual leave')->update([
                'value' => $userannualleavebalancee,
            ]);

            $user->balances()->where('name', 'Annual leave - First half')->update([
                'value' => $annualleavehalfdayy,
            ]);

            $user->balances()->where('name', 'Annual leave - Second half')->update([
                'value' => $annualleavehalfdayy,
            ]);
        }

        DB::table('users')->where('name', $request->linemanager)->update(['usertype_id' => '2']);
        $request->session()->flash('successMsg', trans('overtimeerror.updatesuccess'));

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->leaves()->delete();
        $user->overtimes()->delete();
        $user->balances()->delete();
        $user->email = $user->email.'_deleted'.$user->id;
        $user->employee_number = $user->employee_number.'_deleted'.$user->id;
        $user->save();
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function removesuspend($id)
    {
        $user = User::find($id);
        $user->status = 'active';
        $user->save();

        return redirect()->route('admin.users.index');
    }

    public function suspend($id)
    {
        $user = User::find($id);
        $user->status = 'suspended';
        $user->save();

        return redirect()->route('admin.users.show', $user);

    }

    public function balanceedit(User $user)
    {

        $hruser = Auth::user();
        if ($hruser->superadmin !== 'yes') {
            abort(403);

        } else {
            if ($user->contract == 'International') {
                $balances = Balance::where('user_id', $user->id)->get();
                $subsets = $balances->map(function ($balance) {
                    return collect($balance->toArray())

                        ->only(['value', 'leavetype_id'])
                        ->all();
                });

                //annual leave
                $leave1 = $subsets->firstwhere('leavetype_id', '1');
                $balance1 = round($leave1['value'], 3);

                //sick leave sc
                $leave4 = $subsets->firstwhere('leavetype_id', '4');
                $balance4 = round($leave4['value'], 3);

                //sick leave dc
                $leave7 = $subsets->firstwhere('leavetype_id', '7');
                $balance7 = round($leave7['value'], 3);

                //maternity leave
                $leave11 = $subsets->firstwhere('leavetype_id', '11');
                $balance11 = round($leave11['value'], 3);

                //paternity leave
                $leave12 = $subsets->firstwhere('leavetype_id', '12');
                $balance12 = round($leave12['value'], 3);

                //compassionate/welfare leave
                $leave13 = $subsets->firstwhere('leavetype_id', '13');
                $balance13 = round($leave13['value'], 3);

                //home leave
                $leave16 = $subsets->firstwhere('leavetype_id', '16');
                $balance16 = round($leave16['value'], 3);

                //work from home
                $leave22 = $subsets->firstwhere('leavetype_id', '22');
                $balance22 = round($leave22['value'], 3);

                //study leave
                $leave23 = $subsets->firstwhere('leavetype_id', '23');
                $balance23 = round($leave23['value'], 3);

                return view('admin.users.balanceedit', [
                    'user' => $user,
                    'balance1' => $balance1,
                    'balance4' => $balance4,
                    'balance7' => $balance7,
                    'balance11' => $balance11,
                    'balance12' => $balance12,
                    'balance13' => $balance13,
                    'balance16' => $balance16,
                    'balance22' => $balance22,
                    'balance23' => $balance23,
                ]);
            } else {

                $balances = Balance::where('user_id', $user->id)->get();
                $subsets = $balances->map(function ($balance) {
                    return collect($balance->toArray())

                        ->only(['value', 'leavetype_id'])
                        ->all();
                });
                //annual leave
                $leave1 = $subsets->firstwhere('leavetype_id', '1');
                $balance1 = round($leave1['value'], 3);

                //sick leave sc
                $leave4 = $subsets->firstwhere('leavetype_id', '4');
                $balance4 = round($leave4['value'], 3);

                //sick leave dc
                $leave7 = $subsets->firstwhere('leavetype_id', '7');
                $balance7 = round($leave7['value'], 3);

                //marriage leave
                $leave10 = $subsets->firstwhere('leavetype_id', '10');
                $balance10 = round($leave10['value'], 3);

                //maternity leave
                $leave11 = $subsets->firstwhere('leavetype_id', '11');
                $balance11 = round($leave11['value'], 3);

                //paternity leave
                $leave12 = $subsets->firstwhere('leavetype_id', '12');
                $balance12 = round($leave12['value'], 3);

                //compassionate/welfare leave
                $leave13 = $subsets->firstwhere('leavetype_id', '13');
                $balance13 = round($leave13['value'], 3);

                //pilgiramge
                $leave14 = $subsets->firstwhere('leavetype_id', '14');
                $balance14 = round($leave14['value'], 3);

                //cto
                $leave20 = $subsets->firstwhere('leavetype_id', '20');
                $balance20 = round($leave20['value'], 3);

                //work from home
                $leave22 = $subsets->firstwhere('leavetype_id', '22');
                $balance22 = round($leave22['value'], 3);

                //study leave
                $leave23 = $subsets->firstwhere('leavetype_id', '23');
                $balance23 = round($leave23['value'], 3);

                return view('admin.users.balanceedit', [
                    'user' => $user,
                    'balance1' => $balance1,
                    'balance4' => $balance4,
                    'balance7' => $balance7,
                    'balance10' => $balance10,
                    'balance11' => $balance11,
                    'balance12' => $balance12,
                    'balance13' => $balance13,
                    'balance14' => $balance14,
                    'balance20' => $balance20,
                    'balance22' => $balance22,
                    'balance23' => $balance23,
                ]);
            }

        }

    }

    public function balanceupdate(Request $request, User $user)
    {
        $hruser = Auth::user();
        if ($hruser->superadmin !== 'yes') {
            abort(403);
        } else {
            if ($user->contract == 'International') {
                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '1'],
                ])->first()?->update(['value' => $request->annualLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '4'],
                ])->first()?->update(['value' => $request->sickLeaveSC]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '7'],
                ])->first()?->update(['value' => $request->sickLeaveDC]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '11'],
                ])->first()?->update(['value' => $request->maternityLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '12'],
                ])->first()?->update(['value' => $request->paternityLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '13'],
                ])->first()?->update(['value' => $request->welfareLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '16'],
                ])->first()?->update(['value' => $request->homeleave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '22'],
                ])->first()?->update(['value' => $request->wfh]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '23'],
                ])->first()?->update(['value' => $request->study]);

            } else {
                //national
                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '1'],
                ])->first()?->update(['value' => $request->annualLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '4'],
                ])->first()?->update(['value' => $request->sickLeaveSC]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '7'],
                ])->first()?->update(['value' => $request->sickLeaveDC]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '10'],
                ])->first()?->update(['value' => $request->marriageLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '11'],
                ])->first()?->update(['value' => $request->maternityLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '12'],
                ])->first()?->update(['value' => $request->paternityLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '13'],
                ])->first()?->update(['value' => $request->welfareLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '14'],
                ])->first()?->update(['value' => $request->PilgrimageLeave]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '20'],
                ])->first()?->update(['value' => $request->compansetion]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '22'],
                ])->first()?->update(['value' => $request->wfh]);

                Balance::where([
                    ['user_id', $user->id],
                    ['leavetype_id', '23'],
                ])->first()?->update(['value' => $request->study]);

            }

            $emailme = 'danial.janboura@nrc.no';
            $timeofchange = date('Y-m-d H:i:s');
            $details = [
                'hrname' => $hruser->name,
                'staffaffected' => $user->name,
                'timeofchange' => $timeofchange,
                'reason' => $request->reason,
            ];
            Mail::to($emailme)->send(new MailBalance($details));
            $request->session()->flash('successMsg', trans('overtimeerror.balancesuccess'));

            return redirect()->route('admin.users.show', $user);
        }

    }

    public function export()
    {
        $user = Auth::user();
        if ($user->hradmin !== 'yes') {
            abort(403);
        } else {
            $users = User::all()->except(1);

            return Excel::download(new UsersExport($users), 'users.xlsx');
        }
    }

    public function balanceexport(Request $request)
    {

        $request->validate([
            'start_date',
            'name',
        ]);
        $hruser = Auth::user();

        $name = $request->name;
        $contract = $request->contract;
        $start_date = $request->start_date;
        $staffstatus = $request->staffstatus;
        $linemanager = $request->linemanager;

        if ($start_date == null) {
            $start_datee = '1980-01-01';
        } elseif ($start_date !== null) {
            $start_datee = $start_date;
        }

        if ($staffstatus == null) {
            $staffstatuse = ['active', 'suspended'];
        } elseif ($staffstatus !== null) {
            $staffstatuse = $staffstatus;
        }

        if ($contract == null) {
            $contracte = ['National', 'International', 'NA'];
        } elseif ($contract !== null) {
            $contracte = $contract;
        }

        if ($request->name == null) {
            $staffwithstatus = User::WhereIn('status', $staffstatuse)->get();
            if (count($staffwithstatus)) {
                $hrsubsets = $staffwithstatus->map(function ($staffwithstatus) {
                    return collect($staffwithstatus->toArray())
                        ->only(['id'])
                        ->all();
                });
                $users = User::whereIn('id', $hrsubsets)->where([
                    ['joined_date', '>=', $start_datee],

                ])->WhereIn('contract', $contracte)->get();
            }
        } else {
            $userid = User::where('name', $name)->value('id');
            $users = User::where([
                ['id', $userid],
                ['joined_date', '>=', $start_datee],
            ])->WhereIn('contract', $contracte)->get();
        }

        if ($linemanager !== null) {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff)) {
                $subsets = $staff->map(function ($staff) {
                    return collect($staff->toArray())

                        ->only(['id'])
                        ->all();
                });

                $users = User::whereIn('id', $subsets)->where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->get();
            } else {
                $users = User::where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->Where('status', 'nothing to show')->get();
            }
        }

        return Excel::download(new BalanceExport($users), 'balances.xlsx');
    }

    public function import(Request $request)
    {
        set_time_limit(300);
        activity()->disableLogging();
        $file = $request->file('file');

        Excel::import(new UsersImport, $request->file('file'));
        activity()->enableLogging();
    }

    public function importshow()
    {
        return view('admin.users.importshow');
    }

    public function createbalance()
    {
        $users = User::all()->except(1);
        $leavetypes = Leavetype::all();
        foreach ($users as $user) {
            foreach ($leavetypes as $leavetype) {
                $user->balances()->create([
                    'name' => $leavetype->name,
                    'value' => $leavetype->value,
                    'leavetype_id' => $leavetype->id,
                ]);
            }
        }

        return redirect()->route('admin.users.index');
    }

    public function search(Request $request)
    {

        $request->validate([
            'start_date',
            'name',
        ]);

        $hruser = Auth::user();

        $name = $request->name;
        $contract = $request->contract;
        $start_date = $request->start_date;

        $staffstatus = $request->staffstatus;
        $linemanager = $request->linemanager;

        if ($start_date == null) {
            $start_datee = '1980-01-01';
        } elseif ($start_date !== null) {
            $start_datee = $start_date;
        }

        if ($staffstatus == null) {
            $staffstatuse = ['active', 'suspended', '', null];
        } elseif ($staffstatus !== null) {
            $staffstatuse = $staffstatus;
        }

        if ($contract == null) {
            $contracte = ['National', 'International', 'NA'];
        } elseif ($contract !== null) {
            $contracte = $contract;
        }

        if ($request->name == null) {

            $staffwithsameoffice = User::WhereIn('status', $staffstatuse)->get();
            if (count($staffwithsameoffice)) {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $users = User::whereIn('id', $hrsubsets)->where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->get()->except(1);

            } else {
                $users = User::where('id', 99999)->where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->get()->except(1);
            }

        } else {
            $userid = User::where('name', $name)->value('id');
            $users = User::where([
                ['id', $userid],
                ['joined_date', '>=', $start_datee],
            ])->WhereIn('contract', $contracte)->get()->except(1);
        }

        if ($linemanager !== null) {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff)) {
                $subsets = $staff->map(function ($staff) {
                    return collect($staff->toArray())

                        ->only(['id'])
                        ->all();
                });
                $users = User::whereIn('id', $subsets)->where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->get()->except(1);
            } else {
                $users = User::where([
                    ['joined_date', '>=', $start_datee],
                ])->WhereIn('contract', $contracte)->Where('status', 'nothing to show')->get()->except(1);
            }

        }

        switch ($request->input('action')) {
            case 'view':
                return view('admin.users.search', ['users' => $users, 'name' => $name, 'start_date' => $start_datee]);
                break;

            case 'excel':
                return Excel::download(new UsersExport($users), 'users.xlsx');
                break;
        }

    }
}

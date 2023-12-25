<?php

namespace App\Http\Controllers;

use App\Exports\OvertimesExport;
use App\Mail\Overtime as MailOvertime;
use App\Mail\Overtimeafterlm as MailOvertimeafterlm;
use App\Mail\Overtimefinal as MailOvertimefinal;
use App\Mail\Overtimerejected as MailOvertimerejected;
use App\Models\Balance;
use App\Models\Overtime;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeController extends Controller
{
  
    public function index()
    {
        $user = Auth::user();
        $overtime = Overtime::where('user_id', $user->id)->get();

        return view('overtimes.index', ['overtimes' => $overtime]);
    }

    public function create()
    {
        $user = Auth::user();
        $userss = User::where([
            ['linemanager', $user->name],
            ['grade' ,'<', 3],
            ])->get();
        return view('overtimes.create',['userss' => $userss]);
    }

   
    public function store(Request $request)
    {
        
        $request->validate([

            'type' => 'required',
            'date' => 'required',
            'start_hour' => 'required',
            'end_hour' => 'required|after:start_hour',
            'reason' => 'required',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:3072',

        ], [
            'type.required' => trans('overtimeerror.type'), // custom message
            'date.required' => trans('overtimeerror.date'), // custom message
            'start_hour.required' => trans('overtimeerror.starthour'), // custom message
            'end_hour.required' => trans('overtimeerror.endhour'), // custom message
            'end_hour.after' => trans('overtimeerror.after'), // custom message
            'reason.required' => trans('overtimeerror.reason'), // custom message
            'file.mimes' => trans('overtimeerror.mimes'), // custom message
            'file.max' => trans('overtimeerror.max'), // custom message

        ]
        );
        $nrcholidays = [
            '2023-09-07',
            '2023-09-27',
            '2023-12-10',  
            '2023-12-25',
            '2024-01-01',

        ];

        if ($request->mystaff !== null)
        {
            $user = User::where('employee_number', $request->mystaff)->firstOrFail();
            $onbehalfnote = $request->input('reason') . " - Payment overtime - was submitted by LM on behalf of requester";
            $request->merge([
                'reason' => $onbehalfnote,
            ]);
        }
        elseif ($request->mystaff == null) {
            // getting the balance for the user for the inserted leave type
            $user = Auth::user();
            
        }

        // if ($user->grade == null )
        // {

        //     return redirect()->back()->with("error", trans('overtimeerror.grade'));

        // }

        //    if ($user->grade >= "7")
        //    {
        //     return redirect()->back()->with("error", trans('overtimeerror.gradetoohigh'));
        //    }

        if ($request->type == 'holiday' && !in_array($request->date , $nrcholidays))
        {

            return redirect()->back()->with("error", trans('overtimeerror.holiday'));
        }

        $overtimessubmitted = Overtime::where([
            ['user_id', $user->id],
            ['date', $request->date],
            ['status', '!=', 'Declined by LM'],
            ['status', '!=', 'Declined by HR'],

        ])->get();

        $counted = count($overtimessubmitted);

        if ($counted > 0) {
            return redirect()->back()->with('error', trans('overtimeerror.sameday'));
        } else {

            $stime = $request->start_hour;
            $etime = $request->end_hour;
            $starttime1 = new DateTime($stime);
            $endtime2 = new DateTime($etime);
            $interval = $starttime1->diff($endtime2);
            $hourss = $interval->format('%h');
            $minss = $interval->format('%i');
            $units = round($minss / 30) * 30;
            $mintohour = $units / 60;
            $last = $hourss + $mintohour;

            $datenow = Carbon::now();
            $datenoww = new DateTime($datenow);
            $monthnow = $datenoww->format('m');

            //submitted hours during a month
            // $submittedhours = Overtime::where([
            //     ['user_id', $user->id],
            //     ])->where(function($query) {
            //         $query->where('status','Pending LM Approval')
            //                     ->orWhere('status','Pending HR Approval')
            //                     ->orWhere('status','Pending extra Approval')
            //                     ->orWhere('status','Approved');
            //     })->whereMonth('date',$monthnow)->sum('hours');

            // $submittedwithrequest = $submittedhours + $last;

            // if ($submittedwithrequest > 40)
            // {
            //     return redirect()->back()->with("error", trans('overtimeerror.toomuch'));
            // }

            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('public/overtimes');
            }
            $overtime = new Overtime();
            $overtime->type = $request->type;
            $overtime->date = $request->date;
            $overtime->start_hour = $request->start_hour;
            $overtime->end_hour = $request->end_hour;
            $overtime->reason = $request->reason;
            $overtime->hours = $last;
            if ($request->hasFile('file')) {
                $overtime->path = $path;
            }
            // $overtime->overtimetype_id = $request->overtimetype_id;
            $overtime->user_id = $user->id;
            if (! isset($user->linemanager)) {
                $overtime->status = 'Pending HR Approval';

            } else {

                $overtime->status = 'Pending LM Approval';
                $dayname = Carbon::parse($overtime->date)->format('l');
                $linemanageremail = User::where('name', $user->linemanager)->value('email');

                // dd($linemanageremail);
                $details = [
                    'requestername' => $user->name,
                    'linemanagername' => $user->linemanager,
                    'linemanageremail' => $linemanageremail,
                    'title' => 'Overtime Request Approval - '.$overtime->type,
                    'overtimetype' => $overtime->type,
                    'dayname' => $dayname,
                    'date' => $overtime->date,
                    'start_hour' => $overtime->start_hour,
                    'end_hour' => $overtime->end_hour,
                    'hours' => $overtime->hours,
                    'comment' => $overtime->reason,
                ];

                Mail::to($linemanageremail)->send(new MailOvertime($details));

            }
            if ($overtime->type == 'workday' && $user->grade < '3')
            {

                $overtime->value = $last * 1.5;
            }
            elseif ($overtime->type == 'workday' || $user->contract !== "National") {
                $overtime->value = $last * 1;
            }
            

            else {
                $overtime->value = $last * 2;
            }
    

            $overtime->save();
            $request->session()->flash('successMsg', trans('overtimeerror.success'));

            // dd($partialstoannual);
            return redirect()->route('overtimes.index');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show($overtimeid)
    {

        $id = decrypt($overtimeid);
        $overtime = Overtime::findOrFail($id);

        $authuser = Auth::user();
        $overtimelmname = $overtime->user->linemanager;
        $authusername = $authuser->name;

        if ($overtime->user == $authuser OR $authuser->hradmin == "yes" OR $authusername == $overtimelmname)
        {
            $overtimes = Overtime::all();
            $users = User::all();
            $currentlm = $overtime->user->linemanager;
    
    
            return view('overtimes.show', ['overtime' => $overtime, 'overtimes' => $overtimes, 'users' => $users,'currentlm'=>$currentlm]);
        }
        else
        {
            abort(403);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $authuser = Auth::user();
        $overtime = Overtime::find($id);

        if ($authuser->id == $overtime->user->id)
        {
            if (isset($overtime->path)) {
                $file_path = public_path() . '/storage/overtimes/' . basename($overtime->path);
                unlink($file_path);
            }
    
            $overtime->delete();
            return redirect()->route('overtimes.index');
        }
        else
        {
            abort(403);
        }
    }

    public function approved(Request $request, $id)
    {
        $lmuser = Auth::user();
        $overtime = Overtime::find($id);
        $requester = $overtime->user;

        if($lmuser->usertype_id == "2" && $lmuser->name == $requester->linemanager)
        {
            $overtime->status = 'Pending HR Approval';
        $overtime->lmapprover = $lmuser->name;
        $overtime->lmcomment = $request->comment;
        $overtime->lmdate = Carbon::now();
        $overtime->save();

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester = $overtime->user;

        // dd($linemanageremail);
        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            // 'linemanageremail' => $linemanageremail,
            'title' => 'Overtime Request - '.$overtime->type.' - Approved by Line Manager',
            'overtimetype' => $overtime->type,
            'dayname' => $dayname,
            'date' => $overtime->date,
            'start_hour' => $overtime->start_hour,
            'end_hour' => $overtime->end_hour,
            'hours' => $overtime->hours,
            'status' => $overtime->status,
            'comment' => $overtime->reason,
            'lmcomment' => $overtime->lmcomment,
        ];

        Mail::to($requester->email)->send(new MailOvertimeafterlm($details));

        return redirect()->route('overtimes.approval')->with("success", "Request has been approved");
        }
        else
        {
            abort(403);
        }
        

    }

    public function declined(Request $request, $id)
    {
        $lmuser = Auth::user();
        $overtime = Overtime::find($id);
        $requester = $overtime->user;

        if ($lmuser->usertype_id == "2" && $lmuser->name == $requester->linemanager)
        {
            $overtime->status = 'Declined by LM';
            $overtime->lmapprover = $lmuser->name;
            $overtime->lmcomment = $request->comment;
            $overtime->lmdate = Carbon::now();
            $overtime->save();
    
            $dayname = Carbon::parse($overtime->date)->format('l');
            $requester = $overtime->user;
    
            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type.' - Declined by Line Manager',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' => $overtime->reason,
                'lmcomment' => $overtime->lmcomment,
            ];
    
            Mail::to($requester->email)->send(new MailOvertimeafterlm($details));
    
            return redirect()->route('overtimes.approval')->with("success", "Request has been declined");
        }
        else
        {
            abort(403);
        }
       

    }

    public function forward(Request $request, $id)
    {
        $overtime = Overtime::find($id);
        $overtime->status = 'Pending extra Approval';
        $overtime->exapprover = $request->extra;
        $overtime->save();

        return redirect()->route('overtimes.hrapproval');
    }

    public function exapproved(Request $request, $id)
    {
        $exuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Approved by extra Approval';
        $overtime->exapprover = $exuser->name;
        $overtime->excomment = $request->comment;
        $overtime->exdate = Carbon::now();
        $overtime->save();

        return redirect()->route('overtimes.approval');
    }

    public function exdeclined(Request $request, $id)
    {
        $exuser = Auth::user();
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined by extra Approval';
        $overtime->exapprover = $exuser->name;
        $overtime->excomment = $request->comment;
        $overtime->exdate = Carbon::now();
        $overtime->save();

        return redirect()->route('overtimes.approval');
    }

    public function hrapproved(Request $request, $id)
    {
        $hruser = Auth::user();

        if ($hruser->hradmin !== "yes")
        {
            abort(403);
        }
        else
        {
            $overtime = Overtime::find($id);
            $overtime->status = 'Approved';
            $overtime->hrapprover = $hruser->name;
            $overtime->hrcomment = $request->comment;
            $overtime->hrdate = Carbon::now();
            $overtime->save();
    
            if ($overtime->type == 'workday' || $overtime->type == 'holiday' || $overtime->type == 'week-end') {
                $partialstoannual = $overtime->value / 8;
    
                $user = $overtime->user;
                $dateafter2months = Carbon::now()->addMonths(2);
                $dateafter2monthsnewasdate = new DateTime($dateafter2months);
                $dateafter2monthsnewasdatefinal = $dateafter2monthsnewasdate->format('Y-m-d');
                // dd($dateafter2monthsnewasdatefinal);
    
                $overtime->comlists()->create([
                    'user_id' => $user->id,
                    'hours' => $partialstoannual,
                    // 'autodate' => $dateafter2monthsnewasdatefinal,
                ]);
    
                $overtime->comlists()->where([
                    ['user_id', $user->id],
                    ['overtime_id',  $overtime->id],
                ])->update([
                    'autodate' => $dateafter2monthsnewasdatefinal,
                ]);
    
                $balances = Balance::where('user_id', $overtime->user->id)->get();
                $subsets = $balances->map(function ($balance) {
                    return collect($balance->toArray())
    
                        ->only(['value', 'leavetype_id'])
                        ->all();
                });
                $final = $subsets->firstwhere('leavetype_id', '18');
    
                $finalfinal = $final['value'];
                $currentbalance = $finalfinal;
    
                $newbalance = $currentbalance + $partialstoannual;
    
                Balance::where([
                    ['user_id', $overtime->user->id],
                    ['leavetype_id', '18'],
                ])->update(['value' => $newbalance]);
            }
    
            // if ($overtime->type == 'workday') {
            //     $partialstoannual = $overtime->value / 8;
    
            //     $user = $overtime->user;
            //     $dateafter3months = Carbon::now()->addMonths(3);
            //     $dateafter3monthsnewasdate = new DateTime($dateafter3months);
            //     $dateafter3monthsnewasdatefinal = $dateafter3monthsnewasdate->format('Y-m-d');
            //     // dd($dateafter3monthsnewasdatefinal);
    
            //     $overtime->comlists()->create([
            //         'user_id' => $user->id,
            //         'hours' => $partialstoannual,
            //         // 'autodate' => $dateafter3monthsnewasdatefinal,
            //     ]);
    
            //     $overtime->comlists()->where([
            //         ['user_id', $user->id],
            //         ['overtime_id',  $overtime->id],
            //     ])->update([
            //         'autodate' => $dateafter3monthsnewasdatefinal,
            //     ]);
    
            //     $balances = Balance::where('user_id', $overtime->user->id)->get();
            //     $subsets = $balances->map(function ($balance) {
            //         return collect($balance->toArray())
    
            //             ->only(['value', 'leavetype_id'])
            //             ->all();
            //     });
            //     $final = $subsets->firstwhere('leavetype_id', '18');
    
            //     $finalfinal = $final['value'];
            //     $currentbalance = $finalfinal;
    
            //     $newbalance = $currentbalance + $partialstoannual;
    
            //     Balance::where([
            //         ['user_id', $overtime->user->id],
            //         ['leavetype_id', '18'],
            //     ])->update(['value' => $newbalance]);
            // }
    
            $dayname = Carbon::parse($overtime->date)->format('l');
            $requester = $overtime->user;
    
            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                'hrname' => $overtime->hrapprover,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Overtime Request - '.$overtime->type.' - Approved by HR',
                'overtimetype' => $overtime->type,
                'dayname' => $dayname,
                'date' => $overtime->date,
                'start_hour' => $overtime->start_hour,
                'end_hour' => $overtime->end_hour,
                'hours' => $overtime->hours,
                'status' => $overtime->status,
                'comment' => $overtime->reason,
                'lmcomment' => $overtime->lmcomment,
                'hrcomment' => $overtime->hrcomment,
            ];
    
            Mail::to($requester->email)->send(new MailOvertimefinal($details));
    
            return redirect()->route('overtimes.hrapproval');
        }
       

    }

    public function hrdeclined(Request $request, $id)
    {
        $hruser = Auth::user();

        if($hruser->hradmin !== "yes")
        {
            abort(403);
        }

        else
        {
        $overtime = Overtime::find($id);
        $overtime->status = 'Declined by HR';
        $overtime->hrapprover = $hruser->name;
        $overtime->hrcomment = $request->comment;
        $overtime->hrdate = Carbon::now();
        
        $overtime->save();

        $dayname = Carbon::parse($overtime->date)->format('l');
        $requester = $overtime->user;

        // dd($linemanageremail);
        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            'hrname' => $overtime->hrapprover,
            // 'linemanageremail' => $linemanageremail,
            'title' => 'Overtime Request - '.$overtime->type.' - Declined by HR',
            'overtimetype' => $overtime->type,
            'dayname' => $dayname,
            'date' => $overtime->date,
            'start_hour' => $overtime->start_hour,
            'end_hour' => $overtime->end_hour,
            'hours' => $overtime->hours,
            'status' => $overtime->status,
            'comment' => $overtime->reason,
            'lmcomment' => $overtime->lmcomment,
            'hrcomment' => $overtime->hrcomment,
        ];

        Mail::to($requester->email)->send(new MailOvertimerejected($details));

        return redirect()->route('overtimes.hrapproval');
        }
        

    }

    public function export()
    {
        $hruser = Auth::user();
        if ($hruser->office == 'CO-Erbil') {
            $overtimes = Overtime::all();

        } else {
            $staffwithsameoffice = User::where('office', $hruser->office)->get();
            if (count($staffwithsameoffice)) {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $overtimes = Overtime::wherein('user_id', $hrsubsets)->get();

            }
        }

        return Excel::download(new OvertimesExport($overtimes), 'overtimes.xlsx');
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name' => 'required',

        ]);

        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        // $leavetype=$request->leavetype;

        $userid = User::where('name', $name)->value('id');
        $userpeopleid = User::where('name', $name)->value('employee_number');

        $overtimes = Overtime::where([

            ['user_id', $userid],
            ['date', '>=', $start_date],
            ['date', '<=', $end_date],

        ])->get();

        $hruser = Auth::user();
        $date = Carbon::now();

        $pdf = Pdf::loadView('admin.allstaffovertimes.report', ['name' => $name, 'userpeopleid' => $userpeopleid, 'hruser' => $hruser, 'date' => $date, 'start_date' => $start_date, 'end_date' => $end_date, 'overtimes' => $overtimes])->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => 'true', 'isRemoteEnabled' => 'true', 'isPhpEnabled' => 'true'])->setpaper('a4', 'portrait');

        return $pdf->stream();

    }

    public function search(Request $request)
    {
        $request->validate([
            'start_date',
            'end_date' => 'nullable|after_or_equal:start_date',
            // 'leavetype' => 'required',
            'name',

        ]);

        $hruser = Auth::user();

        $name = $request->name;
        $overtimetype = $request->overtime;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $office = $request->office;
        $contract = $request->contract;
        $status = $request->status;
        $staffstatus = $request->staffstatus;
        $linemanager = $request->linemanager;

        if ($start_date == null) {
            $start_datee = '2023-01-01';
        } elseif ($start_date !== null) {
            $start_datee = $start_date;
        }

        if ($end_date == null) {
            $end_datee = '2023-12-31';
        } elseif ($end_date !== null) {
            $end_datee = $end_date;
        }

        if ($staffstatus == null) {
            $staffstatuse = ['active', 'suspended'];
        } elseif ($staffstatus !== null) {
            $staffstatuse = $staffstatus;
        }

        if ($office == null) {
            $officee = ['CO-Erbil', 'NIAO', 'KRAO', 'CIAO', 'SIAO'];
        } elseif ($office !== null) {
            $officee = $office;
        }

        if ($status == null) {
            $statuse = ['Approved', 'Declined by HR', 'Declined by LM', 'Pending HR Approval', 'Pending LM Approval', 'Pending extra Approval', 'Approved by extra Approval', 'Declined by extra Approval'];

        } 
        
        if ($contract == null) {
            $contracte = ['National', 'International', 'NA'];
        } elseif ($contract !== null) {
            $contracte = $contract;
        }
        
        elseif ($status !== null) {
            $statuse = $status;
        }

        if ($overtimetype == null) {
            $overtimetypee = ['workday', 'week-end', 'holiday'];

        } elseif ($overtimetype !== null) {
            $overtimetypee = $overtimetype;
        }

        if ($request->name == null) {

            if ($hruser->office == 'CO-Erbil') {

                $staffwithsameoffice = User::whereIn('office', $officee)->WhereIn('status', $staffstatuse)->WhereIn('contract', $contracte)->get();
                if (count($staffwithsameoffice)) {

                    $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                        return collect($staffwithsameoffice->toArray())
                            ->only(['id'])
                            ->all();
                    });
                    $overtimes = Overtime::whereIn('user_id', $hrsubsets)->where([

                        ['date', '>=', $start_datee],
                        ['date', '<=', $end_datee],

                    ])->WhereIn('type', $overtimetypee)->WhereIn('status', $statuse)->get();

                }

            } else {
                $staffwithsameoffice = User::where('office', $hruser->office)->WhereIn('status', $staffstatuse)->WhereIn('contract', $contracte)->get();
                if (count($staffwithsameoffice)) {
                    $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                        return collect($staffwithsameoffice->toArray())
                            ->only(['id'])
                            ->all();
                    });
                    $overtimes = Overtime::whereIn('user_id', $hrsubsets)->where([
                        ['date', '>=', $start_datee],
                        ['date', '<=', $end_datee],
                    ])->WhereIn('type', $overtimetypee)->WhereIn('status', $statuse)->get();

                }
            }
        } else {
            $userid = User::where('name', $name)->value('id');

            $overtimes = Overtime::where([

                ['user_id', $userid],
                ['date', '>=', $start_datee],
                ['date', '<=', $end_datee],

            ])->WhereIn('type', $overtimetypee)->WhereIn('status', $statuse)->get();
        }

        if ($linemanager !== null) {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff)) {
                $subsets = $staff->map(function ($staff) {
                    return collect($staff->toArray())

                        ->only(['id'])
                        ->all();
                });

                $overtimes = Overtime::whereIn('user_id', $subsets)->where([
                    ['date', '>=', $start_datee],
                    ['date', '<=', $end_datee],
                ])->WhereIn('type', $overtimetypee)->WhereIn('status', $statuse)->get();
            } else {
                $overtimes = Overtime::where([
                    ['date', '>=', $start_datee],
                    ['date', '<=', $end_datee],
                ])->WhereIn('type', $overtimetypee)->Where('status', 'nothing to show')->get();
            }

        }

        switch ($request->input('action')) {
            case 'view':
                return view('admin.allstaffovertimes.search', ['overtimes' => $overtimes, 'name' => $name, 'start_date' => $start_datee, 'end_date' => $end_datee]);
                break;

            case 'excel':
                return Excel::download(new OvertimesExport($overtimes), 'overtimes.xlsx');
                break;
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use App\Mail\Leave as MailLeave;
use App\Mail\Leaveafterlm as MailLeaveafterlm;
use App\Mail\Leavefinal as MailLeavefinal;
use App\Mail\Leaverejected as MailLeaverejected;
use App\Models\Balance;
use App\Models\Leave;
use App\Models\Leavetype;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Database\Seeders\LeavetypeTableSeeder;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;

class LeaveController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $leave = Leave::where('user_id', $user->id)->with('leavetype')->get();
        // $leave = $user->leaves->with('leavetype');
    

        return view('leaves.index', ['leaves' => $leave]);
    }

    public function create()
    {
        
        $user = Auth::user();
        // $userss = User::where([
        //     ['linemanager', $user->name],
        //     ['grade' ,'<', 3],
        //     ['email', null],
        //     ])->get();
  

            $leavetypes = Leavetype::where($user->contract,'yes')->get();
            $partialleaves = Leavetype::where($user->contract,'yes')->where('canpartial','partial')->pluck('id');
            $hourleave = Leavetype::where($user->contract,'yes')->where('canpartial','hour')->pluck('id');
            $iscalendardays = Leavetype::where($user->contract,'yes')->where('iscalendardays','!=',null)->pluck('id');
            $homeleave = Leavetype::where('name','Home Leave')->pluck('id');
    
            return view('leaves.create', ['leavetypes' => $leavetypes,'partialleaves' => $partialleaves,'iscalendardays'=>$iscalendardays,'homeleave'=>$homeleave,'hourleave'=>$hourleave]);
    }

    public function store(Request $request)
    {
        

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'leavetype_id' => 'required',
            'reason',
            'ispartial',
            'hours' => 'nullable|numeric|max:7',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:3072',

        ],
            [
                'start_date.required' => trans('leaveerror.startdatereq'), // custom message
                'end_date.required' => trans('leaveerror.enddatereq'), // custom message
                'end_date.after_or_equal' => trans('leaveerror.afterorequal'), // custom message
                'file.mimes' => trans('leaveerror.mimes'), // custom message
                'file.max' => trans('leaveerror.max'), // custom message
                'hours.max' => trans('leaveerror.hmax'), // custom message
            ]
        );
        //KRI
        $nrcholidays1 = [
            '2023-09-27',
            '2023-12-10',  
            '2023-12-25',
            '2024-01-01',
   
        ];

        //Fedral Iraq
        $nrcholidays2 = [
            '2023-09-07',
            '2023-09-27',
            '2023-12-10',  
            '2023-12-25',
            '2024-01-01',
        ];

        //international
        $nrcholidays3 = [
            '2023-09-27',
            '2023-12-25',
            '2024-01-01',   
        ];

        

        if ($request->mystaff !== null)
        {
            $user = User::where('employee_number', $request->mystaff)->firstOrFail();
            $onbehalfnote = $request->input('reason') . " - was submitted by LM on behalf of requester";
            $request->merge([
                'reason' => $onbehalfnote,
            ]);
        }
        elseif ($request->mystaff == null) {
            // getting the balance for the user for the inserted leave type
            $user = Auth::user();
            
        }

        
            $leavetype = Leavetype::where('id',$request->leavetype_id)->first();
            $currentbalance = Balance::where('user_id', $user->id)->where('name',$leavetype->name)->pluck('value')[0];
         

            $carryoverleavetype = Leavetype::where('iscarryover','yes')->first();
            $currentcarryover = Balance::where('user_id', $user->id)->where('name',$carryoverleavetype->name)->pluck('value')[0];
            // dd($currentcarryover);
       
        $dateRange = CarbonPeriod::create($request->start_date, $request->end_date);

        // $dates = $dateRange->toArray();
        $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
        $datess = array_values($dates);
        // $datesonly = $dates["date"];
        // dd($datess);

        if ($user->contract == "International")
        {
            // dd($nrcholidays3);
            $numberofmatches = count($matches = array_intersect($nrcholidays3,$datess));
        }
        elseif ($user->contract !== "International")
        {
            if ($user->office == "CO-Erbil" OR $user->office == "KRAO")
            {
                // dd($nrcholidays1);
                $numberofmatches = count($matches = array_intersect($nrcholidays1,$datess));
            }
            else {
                // dd($nrcholidays2);
                $numberofmatches = count($matches = array_intersect($nrcholidays2,$datess));
            }
            
        }
        // $numberofmatches = count($matches = array_intersect($nrcholidays,$datess));

        $hours = $request->hours;

        $fdate = $request->start_date;
        $ldate = $request->end_date;
  
        $start = new DateTime($fdate);
        $end = new DateTime($ldate);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $sickpercentagedays = $interval->days;
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        foreach ($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Fri') {
                $days--;
            }

        }

        if ($leavetype->name == "Home Leave")
        {
            $dayswithoutholidays = 2; 
        }
        else{
        $dayswithoutholidays = $days - $numberofmatches;
        }

        $datenow = Carbon::now();
        $joineddate = new DateTime($user->joined_date);
        $dateenow = new DateTime($datenow);
        $intervall = $joineddate->diff($dateenow);
        $probationdays = $intervall->format('%a');

        $startdayname = Carbon::parse($fdate)->format('l');
        $enddayname = Carbon::parse($ldate)->format('l');

        if ($leavetype->needservicedays > 0 AND $leavetype->needsservicedays > $probationdays)
        {
            return redirect()->back()->with('error', trans('leaveerror.prob')); 
        }
        if ($leavetype->canusecarryover == "yes" AND $dayswithoutholidays > ($currentbalance + $currentcarryover))
        {
            return redirect()->back()->with('error', trans('leaveerror.nobalance'));
        }
        if ($leavetype->iscalendardays !== 'yes' AND $dayswithoutholidays > $currentbalance)
        {
            return redirect()->back()->with('error', trans('leaveerror.nobalance'));
        }
        if ($leavetype->iscalendardays == 'yes' AND $sickpercentagedays > $currentbalance)
        {
            return redirect()->back()->with('error', trans('leaveerror.nobalance'));
        }
        if ($leavetype->needsattachment > 0 AND $leavetype->needsattachment <= $dayswithoutholidays AND $request->hasFile('file') == null)
        {
            return redirect()->back()->with('error', trans('leaveerror.attachment'));
        }
        if ($leavetype->needscomment == "yes" AND $request->reason == null)
        {
            return redirect()->back()->with('error', trans('leaveerror.selfcertificate'));
        }
        if ($leavetype->maxperrequest > 0 AND $leavetype->maxperrequest < $dayswithoutholidays)
        {
            return redirect()->back()->with('error', trans('leaveerror.sickscthree'));
        }
       



        // if ($request->hasFile('file')) {
        //     $path = $request->file('file')->store('public/leaves');
        // }

        $leave = new Leave();
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->reason = $request->reason;
        // if ($request->hasFile('file')) {
        //     $leave->path = $path;
        // }
        
       
        if ($leavetype->canpartial =='hour' AND $request->hours !== '0')
        {
            $leave->hours = $hours;
            $leave->days = $leave->hours / 8;
        }
        else if ($leavetype->canpartial == 'partial' AND $request->ispartial !== null)
        {
            
            $leave->ispartial = "yes";
            $leave->days = '0.5';
        }
        else if ($leavetype->iscalendardays == "yes")
        {
            $leave->days = $sickpercentagedays;
        }
        else
        {
            $leave->days = $dayswithoutholidays;
        }
        $leave->leavetype_id = $request->leavetype_id;
        $leave->user_id = $user->id;
        if (! isset($user->linemanager)) {
            $leave->status = 'Pending HR Approval';

        } else {

            $leave->status = 'Pending LM Approval';

            $linemanageremail = User::where('name', $user->linemanager)->value('email');

            // dd($linemanageremail);
            $details = [
                'requestername' => $user->name,
                'linemanagername' => $user->linemanager,
                'linemanageremail' => $linemanageremail,
                'title' => 'Leave Request Approval - '.$leave->leavetype->name,
                'leavetype' => $leave->leavetype->name,
                'startdayname' => $startdayname,
                'start_date' => $leave->start_date,
                'enddayname' => $enddayname,
                'end_date' => $leave->end_date,
                'days' => $leave->days,
                'comment' => $leave->reason,
            ];

            Mail::to($linemanageremail)->send(new MailLeave($details));
        }
        $leave->save();
        $request->session()->flash('successMsg', trans('overtimeerror.success'));

        return redirect()->route('leaves.index');
   
    }

    public function show($leaveid)
    {
        $id = decrypt($leaveid);
        $leave = Leave::findOrFail($id);
        $authuser = Auth::user();
        $leavelmname = $leave->user->linemanager;
        $authusername = $authuser->name;
        
        if ($leave->user == $authuser OR $authuser->hradmin == "yes" OR $authusername == $leavelmname)
        {
            $users = User::all();
            $currentlm = $leave->user->linemanager;
    
            return view('leaves.show', ['leave' => $leave,'users' => $users,'currentlm'=>$currentlm]);
        }
        else
        {
            abort (403);
        }

        
        // $leavetype = Leavetype::where('id', $leave-)->get();
        // $leaves = Leave::all();
       
    }

    public function edit(Leave $leave)
    {
        //
    }

    public function update(Request $request, Leave $leave)
    {
        //
    }

    public function destroy($id)
    {
        $authuser = Auth::user();
        $leave = Leave::find($id);
 
        if ($authuser->id == $leave->user->id)
        {
            if (isset($leave->path)) {
                $file_path = public_path() . '/storage/leaves/' . basename($leave->path);
                unlink($file_path);
            }
    
            $leave->delete();
            return redirect()->route('leaves.index')->with("success", "Leave is canceled");
        }
        else
        {
            abort(403);
        }
     
    }

    public function approved(Request $request, $id)
    {
        $lmuser = Auth::user();
        $leave = Leave::find($id);
        $requester=$leave->user;

        if ($lmuser->usertype_id == "2" && $lmuser->name == $requester->linemanager)
        {
            $leave->status = 'Pending HR Approval';
        $leave->lmapprover = $lmuser->name;
        
        $leave->lmcomment = $request->comment;
        $leave->lmdate = Carbon::now();

        $startdayname = Carbon::parse($leave->start_date)->format('l');
        $enddayname = Carbon::parse($leave->end_date)->format('l');

        $requester = $leave->user;
        // $linemanageremail = User::where('name',$requester->linemanager)->value('email');

        // dd($linemanageremail);
        $details = [
            'requestername' => $requester->name,
            'linemanagername' => $requester->linemanager,
            // 'linemanageremail' => $linemanageremail,
            'title' => 'Leave Request - '.$leave->leavetype->name.' - Approved by Line Manager',
            'startdayname' => $startdayname,
            'start_date' => $leave->start_date,
            'enddayname' => $enddayname,
            'end_date' => $leave->end_date,
            'days' => $leave->days,
            'status' => $leave->status,
            'comment' => $leave->reason,
            'lmcomment' => $leave->lmcomment,
        ];

        Mail::to($requester->email)->send(new MailLeaveafterlm($details));

        $leave->save();

        return redirect()->route('leaves.approval')->with("success", "Request has been approved");
        }
        else
        {
            abort(403);
        }
        

    }

    public function declined(Request $request, $id)
    {
        $lmuser = Auth::user();
        $leave = Leave::find($id);
        $requester=$leave->user;

        if ($lmuser->usertype_id == "2" && $lmuser->name == $requester->linemanager)
        {
            $leave->status = 'Declined by LM';
            $leave->lmapprover = $lmuser->name;
            $leave->lmcomment = $request->comment;
            $leave->lmdate = Carbon::now();
    
            $startdayname = Carbon::parse($leave->start_date)->format('l');
            $enddayname = Carbon::parse($leave->end_date)->format('l');
    
            $requester = $leave->user;
            // $linemanageremail = User::where('name',$requester->linemanager)->value('email');
    
            // dd($linemanageremail);
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                // 'linemanageremail' => $linemanageremail,
                'title' => 'Leave Request - '.$leave->leavetype->name.' - Declined by Line Manager',
                'startdayname' => $startdayname,
                'start_date' => $leave->start_date,
                'enddayname' => $enddayname,
                'end_date' => $leave->end_date,
                'days' => $leave->days,
                'status' => $leave->status,
                'comment' => $leave->reason,
                'lmcomment' => $leave->lmcomment,
            ];
    
            Mail::to($requester->email)->send(new MailLeaveafterlm($details));
    
            $leave->save();
    
            return redirect()->route('leaves.approval')->with("success", "Request has been declined");
        }
        else
        {
            abort(403);
        }
       

    }

    public function forward(Request $request, $id)
    {
        $leave = Leave::find($id);
        $leave->status = 'Pending extra Approval';
        $leave->exapprover = $request->extra;
        $leave->save();

        return redirect()->route('leaves.hrapproval');
    }

    public function exapproved(Request $request, $id)
    {
        $exuser = Auth::user();
        $leave = Leave::find($id);
        $leave->status = 'Approved by extra Approval';
        $leave->exapprover = $exuser->name;
        $leave->excomment = $request->comment;
        $leave->exdate = Carbon::now();
        $leave->save();

        return redirect()->route('leaves.approval');
    }

    public function exdeclined(Request $request, $id)
    {
        $exuser = Auth::user();
        $leave = Leave::find($id);
        $leave->status = 'Declined by extra Approval';
        $leave->exapprover = $exuser->name;
        $leave->excomment = $request->comment;
        $leave->exdate = Carbon::now();
        $leave->save();

        return redirect()->route('leaves.approval');
    }

    public function hrapproved(Request $request, $id)
    {
        $hruser = Auth::user();
        if($hruser->hradmin !== "yes")
        {
            abort(403);
        }
        else
        {
            $leave = Leave::find($id);

            $leavetype = Leavetype::where('id',$leave->leavetype_id)->first();
            $currentbalance = Balance::where('user_id', $leave->user->id)->where('name',$leavetype->name)->pluck('value')[0];
            

            $carryoverleavetype = Leavetype::where('iscarryover','yes')->first();
            $currentcarryover = Balance::where('user_id', $leave->user->id)->where('name',$carryoverleavetype->name)->pluck('value')[0];

            if ($leavetype->canusecarryover == 'yes')
            {
                $newbalance = $currentbalance + $currentcarryover - $leave->days;
            }
            else if ($leavetype->issicksc)
            {
                $newbalance = $currentbalance - 1;
            }
            else
            {$newbalance = $currentbalance - $leave->days;}

        if ($newbalance < 0) {
            return redirect()->route('leaves.hrapproval')->with('error', 'No enough balance for this type, you can only decline the leave');

        } else {
            $leave->status = 'Approved';
            $leave->hrapprover = $hruser->name;
            $leave->hrcomment = $request->comment;
            $leave->hrdate = Carbon::now();

            $startdayname = Carbon::parse($leave->start_date)->format('l');
            $enddayname = Carbon::parse($leave->end_date)->format('l');

            $requester = $leave->user;

            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                'hrname' => $leave->hrapprover,
                'title' => 'Leave Request - '.$leave->leavetype->name.' - Approved by HR',
                'startdayname' => $startdayname,
                'start_date' => $leave->start_date,
                'enddayname' => $enddayname,
                'end_date' => $leave->end_date,
                'days' => $leave->days,
                'status' => $leave->status,
                'comment' => $leave->reason,
                'newbalance' => $newbalance,
                'lmcomment' => $leave->lmcomment,
                'hrcomment' => $leave->hrcomment,
            ];

            Mail::to($requester->email)->send(new MailLeavefinal($details));
            $leave->save();

            if ($leavetype->canusecarryover == 'yes')
            {
                if ($currentcarryover == 0)
                {
                    Balance::where([
                        ['user_id', $leave->user->id],
                        ['leavetype_id', $leave->leavetype_id],
                    ])->update(['value' => $newbalance]);
                 
                }
                else
                {
                    if ($currentcarryover >= $leave->days)
                    {
                        $newcarry = $currentcarryover - $leave->days;
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['name', 'Carry over'],
                        ])->update(['value' => $newcarry]);
                    }
                    else if ($currentcarryover < $leave->days)
                    {
                        
                        $newannualbalance = $currentbalance - ($leave->days - $currentcarryover);
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', $leave->leavetype_id],
                        ])->update(['value' => $newannualbalance]);

                        $newcarry = 0;
                        Balance::where([
                            ['user_id', $leave->user->id],
                            ['name', 'Carry over'],
                        ])->update(['value' => $newcarry]);

                    }
                }   
            }
            else if ($leavetype->issicksc)
            {
                Balance::where([
                    ['user_id', $leave->user->id],
                    ['leavetype_id', $leave->leavetype_id],
                    ])->update(['value' => $newbalance]);
            }
            else
            {
                Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', $leave->leavetype_id],
                        ])->update(['value' => $newbalance]);
            }
            return redirect()->route('leaves.hrapproval');
        }
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
            $leave = Leave::find($id);
            $leave->status = 'Declined by HR';
            $leave->hrapprover = $hruser->name;
            $leave->hrcomment = $request->comment;
            $leave->hrdate = Carbon::now();
    
            $startdayname = Carbon::parse($leave->start_date)->format('l');
            $enddayname = Carbon::parse($leave->end_date)->format('l');
    
            $requester = $leave->user;
    
            $details = [
                'requestername' => $requester->name,
                'linemanagername' => $requester->linemanager,
                'hrname' => $leave->hrapprover,
                'title' => 'Leave Request - '.$leave->leavetype->name.' - Declined by HR',
                'startdayname' => $startdayname,
                'start_date' => $leave->start_date,
                'enddayname' => $enddayname,
                'end_date' => $leave->end_date,
                'days' => $leave->days,
                'status' => $leave->status,
                'comment' => $leave->reason,
                'lmcomment' => $leave->lmcomment,
                'hrcomment' => $leave->hrcomment,
            ];
    
            Mail::to($requester->email)->send(new MailLeaverejected($details));
            $leave->save();
    
            return redirect()->route('leaves.hrapproval');
        }
    }

    public function export()
    {
        $hruser = Auth::user();
        if ($hruser->office == 'CO-Erbil') {
            $leaves = Leave::all();

        } else {
            $staffwithsameoffice = User::where('office', $hruser->office)->get();
            if (count($staffwithsameoffice)) {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                $leaves = Leave::wherein('user_id', $hrsubsets)->get();
            }
        }
        return Excel::download(new LeavesExport($leaves), 'leaves.xlsx');
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
        $numberofdays = $request->numberofdays;
        // dd($numberofdays);

        $userid = User::where('name', $name)->value('id');
        $userpeopleid = User::where('name', $name)->value('employee_number');
        $staff = User::find($userid);
        $leaves = Leave::where([

            ['user_id', $userid],
            ['start_date', '>=', $start_date],
            ['end_date', '<=', $end_date],

        ])->get();

        $hruser = Auth::user();
        $date = Carbon::now();
        $annualsubmitted = Leave::where([

            ['user_id', $userid],
            ['start_date', '>=', $start_date],
            ['end_date', '<=', $end_date],
            ['status','Approved'],
           
        ])->where(function ($query) {
            $query->where('leavetype_id', '1')
                ->orWhere('leavetype_id', '13')
                ->orWhere('leavetype_id', '14');
        })->pluck('days');

        
        $countannualsubmitted = $annualsubmitted->sum() + $numberofdays;
        // dd($countannualsubmitted);



            $yearr = date('Y', strtotime($staff->joined_date));
            $dayy = date('d', strtotime($staff->joined_date));
            $monthh = date('m', strtotime($staff->joined_date));

            $carboneddate = new Carbon ($end_date);
            $yearend = $carboneddate->year;
            $monthend = $carboneddate->month;
            $datenoww = Carbon::now();
            $yearnoww = $datenoww->year;
            
           
            //staff joined last year
            if ($yearr < $yearnoww)
            {
                if ($yearend - $yearr >= 5)
                {                    
                    $userannualleavebalancee = (1.92 * $monthend);                   
                }
                else
                {
                    $userannualleavebalancee = (1.75 * $monthend);                   
                }
            }

            else
            {
                if ($dayy < '15')
                    {
                        $userannualleavebalancee = (1.75 * ($monthend - $monthh + 1));
                    }
    
                    else if ($dayy >= '15') 
                    {
                        $userannualleavebalancee = ((1.75 * ($monthend - $monthh)) + 0.5);
                    }
            }




            $result = $userannualleavebalancee - $countannualsubmitted;

        

        $pdf = Pdf::loadView('admin.allstaffleaves.report', ['name' => $name,'numberofdays'=>$numberofdays,'accruedbalance'=>$userannualleavebalancee,'result'=>$result,'sumofannual'=>$countannualsubmitted, 'userpeopleid' => $userpeopleid, 'hruser' => $hruser, 'date' => $date, 'start_date' => $start_date, 'end_date' => $end_date, 'leaves' => $leaves])->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => 'true', 'isRemoteEnabled' => 'true', 'isPhpEnabled' => 'true'])->setpaper('a4', 'portrait');

        return $pdf->stream();

    }

    public function hrdelete(Request $request, $id)
    {
        $leave = Leave::find($id);

            $leavetype = Leavetype::where('id',$leave->leavetype_id)->first();
            $currentbalance = Balance::where('user_id', $leave->user->id)->where('name',$leavetype->name)->pluck('value')[0];
            

            // $carryoverleavetype = Leavetype::where('iscarryover','yes')->first();
            // $currentcarryover = Balance::where('user_id', $leave->user->id)->where('name',$carryoverleavetype->name)->pluck('value')[0];
            if ($leavetype->issicksc)
            {
                $newbalance = $currentbalance + 1;
            }
            else
            {$newbalance = $currentbalance + $leave->days;}
           
            if ($leavetype->issicksc)
            {
                Balance::where([
                    ['user_id', $leave->user->id],
                    ['leavetype_id', $leave->leavetype_id],
                    ])->update(['value' => $newbalance]);
            }
            else
            {
                Balance::where([
                            ['user_id', $leave->user->id],
                            ['leavetype_id', $leave->leavetype_id],
                        ])->update(['value' => $newbalance]);
            }
        $leave->delete();
        $request->session()->flash('successMsg', trans('overtimeerror.hrdelete'));

        return redirect()->route('admin.allstaffleaves.index');

    }

    public function lmrevert(Request $request, $id)
    {
        $leave = Leave::find($id);
        $leave->status = 'Pending LM Approval';
        $leave->lmapprover = null;
        $leave->lmcomment = null;

        $leave->save();

        $request->session()->flash('successMsg', trans('overtimeerror.lmrevert'));

        return redirect()->route('admin.allstaffleaves.index');
    }

    public function search(Request $request)
    {
        $request->validate([

            'start_date',
            'end_date' => 'nullable|after_or_equal:start_date',
            'name',

        ]);

        $hruser = Auth::user();

        $name = $request->name;
        $leavetype = $request->leavetype_id;
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
            $end_datee = '2024-12-31';
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

        } elseif ($status !== null) {
            $statuse = $status;
        }
        if ($contract == null) {
            $contracte = ['National', 'International', 'NA'];
        } elseif ($contract !== null) {
            $contracte = $contract;
        }

        if ($leavetype == null) {
            $leavetypee = Leavetype::all()->pluck('id')->toArray();
        } elseif ($leavetype !== null) {
            $leavetypee = $leavetype;
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
                    $leaves = Leave::whereIn('user_id', $hrsubsets)->where([
                        ['start_date', '>=', $start_datee],
                        ['end_date', '<=', $end_datee],
                    ])->WhereIn('leavetype_id', $leavetypee)->WhereIn('status', $statuse)->get();
            
                }

            } else {
                $staffwithsameoffice = User::where('office', $hruser->office)->WhereIn('status', $staffstatuse)->WhereIn('contract', $contracte)->get();
                if (count($staffwithsameoffice)) {
                    $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                        return collect($staffwithsameoffice->toArray())
                            ->only(['id'])
                            ->all();
                    });
                    $leaves = Leave::whereIn('user_id', $hrsubsets)->where([
                        ['start_date', '>=', $start_datee],
                        ['end_date', '<=', $end_datee],
                    ])->WhereIn('leavetype_id', $leavetypee)->WhereIn('status', $statuse)->get();

                }
            }

        } else {
            $userid = User::where('name', $name)->value('id');

            $leaves = Leave::where([

                ['user_id', $userid],
                ['start_date', '>=', $start_datee],
                ['end_date', '<=', $end_datee],

            ])->WhereIn('leavetype_id', $leavetypee)->WhereIn('status', $statuse)->get();
        }

        if ($linemanager !== null) {
            $staff = User::where('linemanager', $linemanager)->get();
            if (count($staff)) {
                $subsets = $staff->map(function ($staff) {
                    return collect($staff->toArray())

                        ->only(['id'])
                        ->all();
                });

                $leaves = Leave::whereIn('user_id', $subsets)->where([
                    ['start_date', '>=', $start_datee],
                    ['end_date', '<=', $end_datee],
                ])->WhereIn('leavetype_id', $leavetypee)->WhereIn('status', $statuse)->get();
            } else {
                $leaves = Leave::where([
                    ['start_date', '>=', $start_datee],
                    ['end_date', '<=', $end_datee],
                ])->WhereIn('leavetype_id', $leavetypee)->Where('status', 'nothing to show')->get();
            }

        }

        switch ($request->input('action')) {
            case 'view':
                
                return view('admin.allstaffleaves.search', ['leaves' => $leaves, 'name' => $name, 'start_date' => $start_datee, 'end_date' => $end_datee]);
                break;

            case 'excel':
                return Excel::download(new LeavesExport($leaves), 'leaves.xlsx');
                break;
        }

    }
}

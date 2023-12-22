<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policy = Policy::all();
        // $user = Auth::user();

        return view('admin.policies.index', ['policies' => $policy]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authuser = Auth::user();
        if ($authuser->hradmin == "yes")
        {
            return view('admin.policies.create');
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authuser = Auth::user();
        if ($authuser->hradmin !== "yes")
        {
            abort(403);
        }
        else
        {
            $request->validate([

                'name' => 'required|regex:/^[\pL\s]+$/u|min:3|unique:policies,name',
                'desc',
                'created_date' => 'required',
                'lastupdate_date' => 'required',
                'file' => 'required|mimes:jpeg,png,jpg,pdf|max:3072',
            ],[
                'name.regex' => trans('overtimeerror.regex'), // custom message
            ]);
    
            $path = $request->file('file')->storeAs('public/files', $request->name . '.pdf');
    
            $policy = new Policy();
            $policy->name = $request->name;
            $policy->desc = $request->desc;
            $policy->created_date = $request->created_date;
            $policy->lastupdate_date = $request->lastupdate_date;
            $policy->path = $path;
            $policy->save();
    
            $policy = Policy::all();
            return view('admin.policies.index', ['policies' => $policy]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $policy)
    {

        // $authuser = Auth::user();
        // if ($authuser->hradmin == "yes")
        // {
        //     return view('admin.policies.edit', ['policy' => $policy]);
        // }
        // else
        // {
        //     abort(403);
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policy $policy)
    {
        // $authuser = Auth::user();
        // if ($authuser->hradmin == "yes")
        // {
        //     if (isset($request->file)) {
        //         $path = $request->file('file')->storeAs('public/files', $request->name.'.pdf');
        //         $policy->path = $path;
        //     }
    
        //     $policy->name = $request->name;
        //     $policy->desc = $request->desc;
        //     $policy->created_date = $request->created_date;
        //     $policy->lastupdate_date = $request->lastupdate_date;
    
        //     $policy->save();
    
        //     $policy = Policy::all();
    
        //     return view('admin.policies.index', ['policies' => $policy]);
        // }
        // else
        // {
        //     abort(403);
        // }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policy $policy)
    {
        $authuser = Auth::user();
        if ($authuser->hradmin == "yes")
        {
             // File::delete($policy->name);
             // File::delete(public_path("files/{{$policy->name}} . '.pdf'"));
          $file_path = public_path() . '/storage/files/' . $policy->name . '.pdf';
          unlink($file_path);
          $policy->delete();
          return redirect()->route('admin.policies.index');
        }
        else
        {
            abort(403);
        }
    }
}

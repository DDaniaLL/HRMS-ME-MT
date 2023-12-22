<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $authuser = Auth::user();
      
        if($authuser->Office->isco == "yes"){
            $offices = Office::all();
            return view('admin.offices.index', ['offices' => $offices]);
        }
        else {
            abort(403);
        }
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authuser = Auth::user();
        if ($authuser->hradmin == "yes")
        {
            return view('admin.offices.create');
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
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
                'name' => 'required|unique:offices,name',
                'desc',
                
            ]);
    
            
    
            $office = new Office();
            $office->name = $request->name;
            $office->description = $request->desc;
            $office->save();
    
            $office = Office::all();
            return view('admin.offices.index', ['offices' => $office]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $authuser = Auth::user();
        if ($authuser->hradmin == "yes")
        {
             // File::delete($policy->name);
             // File::delete(public_path("files/{{$policy->name}} . '.pdf'"));
          
          $office->delete();
          return redirect()->route('admin.offices.index');
        }
        else
        {
            abort(403);
        }
    }
}

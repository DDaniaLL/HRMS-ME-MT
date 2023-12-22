<?php

namespace App\Http\Controllers;

use App\Models\Leavetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeavetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leavetypes = Leavetype::all();
        return view('admin.leavetypes.index', ['leavetypes' => $leavetypes]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authuser = Auth::user();
        if ($authuser->hradmin == "yes")
        {
            return view('admin.leavetypes.create');
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
                'name' => 'required|unique:leavetypes,name',
                'value',
                
            ]);
       
            $leavetype = new Leavetype();
            $leavetype->name = $request->name;
            $leavetype->value = $request->value;
            $leavetype->save();


    
            $leavetypes = Leavetype::all();
            return view('admin.leavetypes.index', ['leavetypes' => $leavetypes]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leavetype $leavetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leavetype $leavetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leavetype $leavetype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leavetype $leavetype)
    {
        //
    }
}

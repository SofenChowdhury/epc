<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpDesignation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = ErpDesignation::where('active_status', '=', 1)->get();
        return view('backEnd.employees.designation.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'designation_name'=>'required|string|min:1|max:150',
        ]);

        $designation = new ErpDesignation();
        $designation->designation_name = $request->get('designation_name');
        $designation->created_by = Auth::user()->id;

        $result = $designation->save();
        if($result) {
            return redirect('/designation')->with('message-success', 'Designation has been added.');
        } else {
            return redirect('/designation')->with('message-success', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpDesignation::find($id);
        return view('backEnd.employees.designation.index', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            // 'department_name'=>'required',
            'designation_name'=>'required|string|min:1|max:150',
        ]);

        $designation = ErpDesignation::find($id);
        $designation->designation_name = $request->get('designation_name');
        $designation->updated_by = Auth::user()->id;

        $result = $designation->update();
        if($result) {
            return redirect('/designation')->with('message-success', 'Designation has been updated.');
        } else {
            return redirect('/designation')->with('message-success', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDesignationView($id){
        $module = 'deleteDesignation';
         return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteDesignation($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $designation = ErpDesignation::find($id);
        $designation->active_status = 0;

        $results = $designation->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Designation has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}

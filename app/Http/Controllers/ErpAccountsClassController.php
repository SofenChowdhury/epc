<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpAccountsClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpAccountsClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_class = ErpAccountsClass::all();
        return view('backEnd.chart_of_accounts.account_class.index', compact('account_class'));
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
            'class_name' => "required"
        ]);

       $account_class = new ErpAccountsClass();
       $account_class->class_name = $request->class_name;
       $account_class->start_id = $request->start_id;
       $account_class->end_id = $request->end_id;
       $account_class->class_unit = $request->class_unit;
       $account_class->class_unit_type = $request->class_unit_type;
       $account_class->unit_description = $request->unit_description;
       $account_class->created_by = Auth::user()->id;
       $results = $account_class->save();
       
       if($results){
           return redirect()->back()->with('message-success', 'New Account Class has been added successfully');
       }else{
           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
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
        $editData = ErpAccountsClass::find($id);
        $account_class = ErpAccountsClass::all();
        return view('backEnd.chart_of_accounts.account_class.index', compact('editData', 'account_class'));
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
            'class_name' => "required"
        ]);

       $account_class = ErpAccountsClass::find($id);
       $account_class->class_name = $request->class_name;
       $account_class->start_id = $request->start_id;
       $account_class->end_id = $request->end_id;
       $account_class->class_unit = $request->class_unit;
       $account_class->class_unit_type = $request->class_unit_type;
       $account_class->unit_description = $request->unit_description;
       $account_class->updated_by = Auth::user()->id;
       $results = $account_class->update();

       if($results){
           return redirect()->back()->with('message-success', 'Account Class has been updated successfully');
       }else{
           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }

}

<?php

namespace App\Http\Controllers;

use App\ErpEmployee;
use App\ErpPayslipAuthorize;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpPayslipAuthorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorizes = ErpPayslipAuthorize::leftjoin('users','users.id','erp_payslip_authorizes.user_id')
            ->where('users.name','!=',null)
            ->select('users.name','erp_payslip_authorizes.*')->get();
        $next = ErpPayslipAuthorize::max('serial_no') + 1;
        $users = User::where('active_status', '=', 1)->where('id', '!=', '5')->get();
        return view('backEnd.employees.authorize.index', compact('authorizes', 'next', 'users'));
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
            'serial_no' => 'required',
            'user_id' => 'required',
        ]);
        
        $authorise = new ErpPayslipAuthorize();
        $authorise->serial_no = $request->serial_no;
        $authorise->user_id = $request->user_id;
        $result = $authorise->save();
        
        if ($result)
            return redirect('authorize')->with('message-success', 'Authorization has been added.');
        else
            return redirect('authorize')->with('message-danger', 'Something went wrong.');
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
        $editData = ErpPayslipAuthorize::find($id);
        $authorizes = ErpPayslipAuthorize::all();
        $users = User::where('active_status', '=', 1)->where('id', '!=', '5')->get();
        return view('backEnd.employees.authorize.index', compact('editData', 'authorizes', 'users'));
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
            'serial_no' => 'required',
            'user_id' => 'required',
        ]);
    
        $authorise = ErpPayslipAuthorize::find($id);
        $authorise->serial_no = $request->serial_no;
        $authorise->user_id = $request->user_id;
        $result = $authorise->update();
    
        if ($result)
            return redirect('authorize')->with('message-success', 'Authorization has been updated.');
        else
            return redirect('authorize')->with('message-danger', 'Something went wrong.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAuthorize($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $authorise = ErpPayslipAuthorize::findOrFail($id)->delete();
    
        if ($authorise)
            return redirect('authorize')->with('message-danger', 'Authorization has been deleted successfully.');
        else
            return redirect('authorize')->with('message-danger', 'Something went wrong.');
    }
}

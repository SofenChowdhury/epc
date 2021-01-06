<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = ErpPeriod::all();
        return view('backEnd.chart_of_accounts.period.index', compact('periods'));
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
            'period_name' => "required",
            'period_starts' => "required",
            'period_ends' => "required"

        ]);

       $period = new ErpPeriod();
       $period->period_name = $request->period_name;
       $period->period_starts = date('Y-m-d', strtotime($request->period_starts));
       $period->period_ends = date('Y-m-d', strtotime($request->period_ends));
       $period->created_by = Auth::user()->id;
       $get_period_status = $request->period_status;
       if ($get_period_status == 1) {
         $active_period_res = ErpPeriod::where('active_status','=',1)->first();
         if (isset($active_period_res)) {
           $active_period_res->active_status = 0;
           $res = $active_period_res->update();
         }

         $period->active_status = 1;
       } else {
         $period->active_status = 0;
       }
       $results = $period->save();

       if($results){
           return redirect()->back()->with('message-success', 'Period has been added successfully');
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
        $editData = ErpPeriod::find($id);
        $periods = ErpPeriod::all();
        return view('backEnd.chart_of_accounts.period.index', compact('editData', 'periods'));
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
            'period_name' => "required",
            'period_starts' => "required",
            'period_ends' => "required"

        ]);

       $period = ErpPeriod::find($id);
       $period->period_name = $request->period_name;
       $period->period_starts = date('Y-m-d', strtotime($request->period_starts));
       $period->period_ends = date('Y-m-d', strtotime($request->period_ends));
       $period->updated_by = Auth::user()->id;
       $get_period_status = $request->period_status;
       if ($get_period_status == 1) {
         $active_period_res = ErpPeriod::where('active_status','=',1)->first();
         if (isset($active_period_res)) {
           $active_period_res->active_status = 0;
           $res = $active_period_res->update();
         }

         $period->active_status = 1;
       } else {
         $period->active_status = 0;
       }
       $results = $period->update();

       if($results){
           return redirect()->back()->with('message-success', 'Period has been updated successfully');
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
    public function deletePeriodView($id){
         return view('backEnd.chart_of_accounts.period.deletePeriodView', compact('id'));
    }

    public function deletePeriod($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $result = ErpPeriod::destroy($id);
        if($result){
            return redirect()->back()->with('message-success-delete', 'Period has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}

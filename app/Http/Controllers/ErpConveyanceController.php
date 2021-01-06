<?php

namespace App\Http\Controllers;

use App\ErpConveyanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpConveyanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conveyances = ErpConveyanceSchedule::all();
        return view('backEnd.employees.conveyance.index', compact('conveyances'));
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
            'destination'=>'required|string|min:3|max:200',
            'mode'=>'min:0|max:100',
            'rate'=>'required',
        ]);
    
        $conveyance = new ErpConveyanceSchedule();
        $conveyance->destination = $request->get('destination');
        $conveyance->mode = $request->get('mode');
        $conveyance->rate = $request->get('rate');
        $conveyance->remark = $request->get('remark');
        $result = $conveyance->save();
        if($result) {
            return redirect('/conveyance')->with('message-success', 'Conveyance Schedule has been added.');
        } else {
            return redirect('/conveyance')->with('message-success', 'Something went wrong.');
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
        $editData = ErpConveyanceSchedule::find($id);
        $conveyances = ErpConveyanceSchedule::all();
        return view('backEnd.employees.conveyance.index', compact('editData', 'conveyances'));
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
            'destination'=>'required|string|min:3|max:200',
            'mode'=>'min:0|max:100',
            'rate'=>'required',
        ]);
    
        $conveyance = ErpConveyanceSchedule::find($id);
        $conveyance->destination = $request->get('destination');
        $conveyance->mode = $request->get('mode');
        $conveyance->rate = $request->get('rate');
        $conveyance->remark = $request->get('remark');
        $result = $conveyance->update();
        if($result) {
            return redirect('/conveyance')->with('message-success', 'Conveyance Schedule has been updated.');
        } else {
            return redirect('/conveyance')->with('message-success', 'Something went wrong.');
        }
    }
    
    public function increaseConveyanceRate(Request $request)
    {
        $request->validate([
            'increased_rate'=>'required',
        ]);
        
        $conveyances = ErpConveyanceSchedule::all();
        foreach ($conveyances as $conveyance) {
            $conveyance->rate = $conveyance->rate + ($request->increased_rate / 100) * $conveyance->rate;
            $conveyance->update();
        }
        return redirect('/conveyance')->with('message-success', 'Conveyance Schedule has been updated.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConveyanceView($id){
        $module = 'deleteConveyance';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteConveyance($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $conveyance = ErpConveyanceSchedule::find($id);
        $results = $conveyance->delete();
        
        if($results){
            return redirect()->back()->with('message-success-delete', 'Conveyance Schedule has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\ErpProject;
use App\ErpProjectDeliverable;
use App\ErpProjectReporting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProjectDeliverableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $reports = ErpProjectReporting::where('project_id', $id)->get();
        $maxAmendmentDeliverable = 0;
        foreach ($project->deliverable as $deliverable) {

            if ($deliverable->amendment > $maxAmendmentDeliverable) {
                $maxAmendmentDeliverable = $deliverable->amendment;
            }
        }
        return view('backEnd.project_deliverable.create', compact('project', 'reports','maxAmendmentDeliverable'));
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
            'report_name' => 'required|string|min:1|max:200',
        ]);

        $project_id = $request->project_id;
        $project = ErpProject::find($project_id);

        $deliverable = new ErpProjectDeliverable();
        $deliverable->project_id = $project_id;
        $deliverable->project_phase = $project->project_phase;
        $deliverable->report_name = $request->report_name;
        $deliverable->amount_percentage = $request->amount_percentage;
        $deliverable->total_amount = $request->amount_percentage * $project->project_amount;
        $deliverable->amount_received = $request->amount_received;
        if($request->receive_date != null){
            $deliverable->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        if($request->invoice_date != null){
            $deliverable->invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        }
        $deliverable->turnaround_days = $request->turnaround_days;
        if($request->invoice_date != null && $request->turnaround_days != null){
            $deliverable->receive_due_date = date('Y-m-d', strtotime($deliverable->invoice_date) + strtotime($request->turnaround_days));
        }
        $deliverable->interest_rate = $request->interest_rate;
        $deliverable->description = $request->description;
        if ($request->amendment == null) {
            $deliverable->amendment = 0;
        } else {

            $deliverable->amendment = $request->amendment;
            $deliverable->is_amendment = 1;
            $x = ErpProjectDeliverable::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }

        }
        $deliverable->created_by = Auth::user()->id;
        $result = $deliverable->save();

        if($result){
            return redirect('/project/'.$project_id )->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/'.$project_id )->with('message-danger', 'Something went wrong. Please try again.');
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
        $editData = ErpProjectDeliverable::find($id);
        return view('backEnd.project_deliverable.show', compact('editData'));
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
        $editData = ErpProjectDeliverable::find($id);
        $reports = ErpProjectReporting::where('project_id', $editData->project_id)->get();
        $project = ErpProject::find($editData->project_id);
        $maxAmendmentDeliverable = 0;
        foreach ($project->deliverable as $deliverable) {

            if ($deliverable->amendment > $maxAmendmentDeliverable) {
                $maxAmendmentDeliverable = $deliverable->amendment;
            }
        }
        return view('backEnd.project_deliverable.edit', compact('editData', 'reports','maxAmendmentDeliverable'));
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
            'report_name' => 'required|string|min:1|max:200',
        ]);
        $deliverable = ErpProjectDeliverable::find($id);

        $project = ErpProject::find($deliverable->project_id);

        $deliverable->report_name = $request->report_name;
        $deliverable->amount_percentage = $request->amount_percentage;
        $deliverable->total_amount = ($request->amount_percentage * $project->project_amount)/100;
        if($request->receive_date != null){
            $deliverable->receive_date = date('Y-m-d', strtotime($request->receive_date));
            $deliverable->status = 'received';
        }
        if($request->invoice_date != null){
            $deliverable->invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        }
        $deliverable->turnaround_days = $request->turnaround_days;
        if($request->invoice_date != null && $request->turnaround_days != null){
            $deliverable->receive_due_date =  date('Y-m-d', strtotime($deliverable->invoice_date. ' + '.$request->turnaround_days.' days'));
        }
        $deliverable->interest_rate = $request->interest_rate;
        $deliverable->amount_received = $request->amount_received;
        $deliverable->description = $request->description;
        if ($request->amendment != null) {
            $deliverable->amendment = $request->amendment;

        }
        $deliverable->updated_by = Auth::user()->id;
        $result = $deliverable->save();

        if($result){
            return redirect('/project/'.$deliverable->project_id )->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/'.$deliverable->project_id )->with('message-danger', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

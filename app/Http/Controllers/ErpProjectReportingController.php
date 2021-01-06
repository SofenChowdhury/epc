<?php

namespace App\Http\Controllers;

use App\ErpProject;
use App\ErpProjectReporting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProjectReportingController extends Controller
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
        $reporting = ErpProjectReporting::where('project_id', '=', $id)->get();
        $maxAmendmentReporting = 0;
        foreach ($reporting as $report) {

            if ($report->amendment > $maxAmendmentReporting) {
                $maxAmendmentReporting = $report->amendment;
            }
        }
        $project = ErpProject::find($id);
        return view('backEnd.project_reporting.create', compact('project','maxAmendmentReporting'));
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

        $reporting = new ErpProjectReporting();
        $reporting->project_id = $project_id;
        $reporting->project_phase = $project->project_phase;
        $reporting->report_name = $request->report_name;
        $reporting->no_of_copies = $request->no_of_copies;
        if($request->submitted_on != null){
            $reporting->submitted_on = date('Y-m-d', strtotime($request->submitted_on));
        }
        if($request->due_date != null){
            $reporting->due_date = date('Y-m-d', strtotime($request->due_date));
        }
        $reporting->description = $request->description;

        if ($request->amendment == null) {
            $reporting->amendment = 0;
        } else {

            $reporting->amendment = $request->amendment;
        }
        $result = $reporting->save();

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
        $editData = ErpProjectReporting::find($id);

        $reporting = ErpProjectReporting::where('project_id', '=', $editData->project_id)->get();

        $maxAmendmentReporting = 0;
        foreach ($reporting as $report) {

            if ($report->amendment > $maxAmendmentReporting) {
                $maxAmendmentReporting = $report->amendment;
            }
        }
        return view('backEnd.project_reporting.edit', compact('editData','maxAmendmentReporting'));
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

        $reporting = ErpProjectReporting::find($id);
        $reporting->report_name = $request->report_name;
        $reporting->no_of_copies = $request->no_of_copies;
        if($request->submitted_on != null){
            $reporting->submitted_on = date('Y-m-d', strtotime($request->submitted_on));
        }
        if($request->due_date != null){
            $reporting->due_date = date('Y-m-d', strtotime($request->due_date));
        }
        $reporting->description = $request->description;
        if ($request->amendment != null) {
            $reporting->amendment = $request->amendment;
        }
        $result = $reporting->update();

        if($result){
            return redirect('/project/'.$reporting->project_id )->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/'.$reporting->project_id )->with('message-danger', 'Something went wrong. Please try again.');
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

<?php

namespace App\Http\Controllers;

use App\ErpProject;
use App\ErpProjectAdvances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProjectAdvancesController extends Controller
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
        $advances=ErpProjectAdvances::where('project_id', '=', $id)->where('project_phase', '=', $project->project_phase)->get();
        $maxAmendmentAdvance = 0;
        foreach ($advances as $advance) {

            if ($advance->amendment > $maxAmendmentAdvance) {
                $maxAmendmentAdvance = $advance->amendment;
            }
        }

        return view('backEnd.project_advance.create', compact('project','maxAmendmentAdvance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function amendmentCreate(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );

        $request->validate([
            'amount' => 'required',
            'bank_name' => 'min:0|max:200',
        ]);
        $project_id = $id;
        $project = ErpProject::find($id);

        $advance = new ErpProjectAdvances();
        $advance->project_id = $project_id;
        $advance->project_phase = $project->project_phase;
        $advance->amount = $request->amount;
        $advance->bank_name = $request->bank_name;
        $advance->guarantee_amount = $request->guarantee_amount;

        if ($request->receive_date != null) {
            $advance->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        if ($request->effective_through != null) {
            $advance->effective_through = date('Y-m-d', strtotime($request->effective_through));
        }
        $advance->description = $request->description;
        $advance->created_by = Auth::user()->id;


        if ($request->amendment == null) {
            $advance->amendment = 0;
        }
        else {
            $advance->amendment = $request->amendment;
            $advance->is_amendment = 1;
            $x = ErpProjectAdvances::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }

        }



        $result = $advance->save();

        if ($result) {
            return redirect('/project/' . $project_id)->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/' . $project_id)->with('message-danger', 'Something went wrong. Please try again.');
        }


    }

    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'amount' => 'required',
            'bank_name' => 'min:0|max:200',
        ]);

        $project_id = $request->project_id;
        $project = ErpProject::find($project_id);

        $advance = new ErpProjectAdvances();
        $advance->project_id = $project_id;
        $advance->project_phase = $project->project_phase;
        $advance->amount = $request->amount;
        $advance->bank_name = $request->bank_name;
        $advance->guarantee_amount = $request->guarantee_amount;

        if ($request->receive_date != null) {
            $advance->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        if ($request->effective_through != null) {
            $advance->effective_through = date('Y-m-d', strtotime($request->effective_through));
        }
        $advance->description = $request->description;
        $advance->created_by = Auth::user()->id;


        if ($request->amendment == null) {
            $advance->amendment = 0;
        } else {

            $advance->amendment = $request->amendment;
            $advance->is_amendment = 1;
            $x = ErpProjectAdvances::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }

        }
        $result = $advance->save();

        if ($result) {
            return redirect('/project/' . $project_id)->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/' . $project_id)->with('message-danger', 'Something went wrong. Please try again.');
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

        $editData = ErpProjectAdvances::find($id);

        $project = ErpProject::find($editData->project_id);
        $maxAmendmentAdvance = 0;
        foreach ($project->advances as $advance) {

            if ($advance->amendment >  $maxAmendmentAdvance) {
                $maxAmendmentAdvance = $advance->amendment;
            }

        }
        return view('backEnd.project_advance.edit', compact('editData','maxAmendmentAdvance'));
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
            'amount' => 'required',
            'bank_name'=>'min:0|max:200',
        ]);

        $advance =  ErpProjectAdvances::find($id);
        $advance->amount = $request->amount;
        $advance->bank_name = $request->bank_name;
        $advance->guarantee_amount = $request->guarantee_amount;
        if($request->receive_date != null){
            $advance->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        if($request->effective_through != null){
            $advance->effective_through = date('Y-m-d', strtotime($request->effective_through));
        }
        $advance->description = $request->description;
        $advance->created_by = Auth::user()->id;
        if ($request->amendment != null) {
            $advance->amendment = $request->amendment;
            $advance->is_amendment = 1;
            $x = ErpProjectAdvances::where('project_phase', '=', $advance->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }
        }
        $result = $advance->save();

        if($result){
            return redirect('/project/'.$advance->project_id )->with('message-success', 'New Reporting has been assigned.');
        } else {
            return redirect('/project/'.$advance->project_id )->with('message-danger', 'Something went wrong. Please try again.');
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

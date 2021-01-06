<?php

namespace App\Http\Controllers;

use App\ErpProject;
use App\ErpProjectProgressPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProjectProgressPaymentController extends Controller
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
        $progresses = ErpProjectProgressPayment::where('project_id', '=', $id)->where('project_phase', '=', $project->project_phase)->get();
        $maxAmendmentProgress = 0;
        foreach ($progresses as $progress) {

            if ($progress->amendment > $maxAmendmentProgress) {
                $maxAmendmentProgress = $progress->amendment;
            }
        }
        return view('backEnd.project_progressPayment.create', compact('project', 'maxAmendmentProgress'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'p_payment_month' => 'required',
            'invoice_date' => 'required',
            'invoice_amount' => 'required',
            
        ]);
        $project_id = $request->project_id;
        $project = ErpProject::find($project_id);
        $payments = ErpProjectProgressPayment::where('project_id', '=', $project_id)->get();
        foreach ($payments as $payment) {
            if ($payment->p_payment_no == $request->p_payment_no) {

                $request->validate([
                    'p_payment_no' => 'required|unique:erp_project_progress_payments,p_payment_no',
                ]);
            }
        }
        $progress = new ErpProjectProgressPayment();
        $progress->project_id = $project_id;
        $progress->project_phase = $project->project_phase;
        $progress->p_payment_no = $request->p_payment_no;
        $progress->p_payment_month = $request->p_payment_month;

        if ($request->invoice_date != null) {
            $progress->invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        }

        $progress->invoice_amount = $request->invoice_amount;
        if ($request->receive_date != null) {
            $progress->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        $progress->receive_amount = $request->receive_amount;
        $progress->description = $request->description;
        $progress->created_by = Auth::user()->id;

        if ($request->amendment == null) {
            $progress->amendment = 0;
        } else {

            $progress->amendment = $request->amendment;
            $progress->is_amendment = 1;
            $x = ErpProjectProgressPayment::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }
        }
        $result = $progress->save();
        if ($result) {
            return redirect('/project/' . $project_id)->with('message-success', 'New Progress payment has been assigned.');
        } else {
            return redirect('/project/' . $project_id)->with('message-danger', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpProjectProgressPayment::find($id);
        $project = ErpProject::find($editData->project_id);
        $maxAmendmentProgress = 0;
        foreach ($project->progresses as $progresses) {

            if ($progresses->amendment >  $maxAmendmentProgress) {
                $maxAmendmentProgress = $progresses->amendment;
            }

        }
        return view('backEnd.project_progressPayment.edit', compact('editData','maxAmendmentProgress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'p_payment_no' => 'required',
            'p_payment_month' => 'required',
            'invoice_date' => 'required',
            'invoice_amount' => 'required',
            
        ]);
        $progress=ErpProjectProgressPayment::find($id);
        $progress->p_payment_no = $request->p_payment_no;
        $progress->p_payment_month = $request->p_payment_month;

        if ($request->invoice_date != null) {
            $progress->invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        }

        $progress->invoice_amount = $request->invoice_amount;
        if ($request->receive_date != null) {
            $progress->receive_date = date('Y-m-d', strtotime($request->receive_date));
        }
        if ($request->receive_amount != null) {
            $progress->receive_amount = $request->receive_amount;
        }
        if ($request->description != null) {
            $progress->description = $request->description;
        }
        if ($request->amendment != null) {
            $progress->amendment = $request->amendment;

            $progress->is_amendment = 1;
            $x = ErpProjectProgressPayment::where('project_phase', '=', $progress->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }
        }

        $progress->updated_by = Auth::user()->id;


        $result = $progress->save();
        if ($result) {
            return redirect('/project/' .   $progress->project_id)->with('message-success', 'Progress payment has been updated.');
        } else {
            return redirect('/project/' . $progress->project_id)->with('message-danger', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

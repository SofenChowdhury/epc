<?php

namespace App\Http\Controllers;

use App\ErpChalanNo;
use App\ErpConveyanceSchedule;
use App\ErpEmployee;
use App\ErpEmployeeAdvance;
use App\ErpEmployeeBonus;
use App\ErpEmployeeConveyance;
use App\ErpEmployeeOvertimePay;
use App\ErpEmployeeSalary;
use App\ErpProject;
use App\ErpSalaryIncentive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpSalaryIncentiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incentives = ErpSalaryIncentive::all();
        return view('backEnd.employees.incentive.index', compact('incentives'));
    }

    public function allowance()
    {
        $employees = ErpEmployee::where('active_status', '=', 1)->get();
        $salaries = ErpEmployeeSalary::whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
        $incentives = ErpSalaryIncentive::all();
        $conveyances = ErpConveyanceSchedule::all();
        $projects = ErpProject::where('active_status', 1)->get();
        $employee_incentives = ErpEmployeeBonus::all();
        $employee_advances = ErpEmployeeAdvance::all();
        $employee_overtimes = ErpEmployeeOvertimePay::all();
        $employee_conveyances = ErpEmployeeConveyance::all();
        return view('backEnd.employees.bonus.index', compact('employees',
            'salaries',
            'incentives',
            'conveyances',
            'projects',
            'employee_incentives',
            'employee_advances',
            'employee_overtimes',
            'employee_conveyances'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBonus(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
           'employee_id' => 'required',
           'amount' => 'required',
        ]);
        $employee_id = $request->employee_id;

        $bonus = new ErpEmployeeBonus();
        $bonus->employee_id = $employee_id;
        $bonus->bonus_title = $request->bonus_title;
        $bonus->amount = $request->amount;
        if ($request->bonus_title == 'Transport Allowance' || $request->bonus_title == 'Mobile Allowance')
            $bonus->every_month = 1;
        else
            $bonus->every_month = 0;
        $bonus->description = $request->description;
        $bonus->created_by = Auth::user()->id;
        $bonus->save();

        return redirect('/employee/'.$employee_id)->with('message-success', 'Bonus has been added');
    }
    
    public function deleteBonusView($id){
        $module = 'deleteBonus';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteBonus($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $bonus = ErpEmployeeBonus::find($id);
        $result = $bonus->delete();
        
        if($result){
            return redirect()->back()->with('message-success-delete', 'Deletion successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function addAdvance(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'employee_id' => 'required',
            'amount' => 'required',
        ]);
        $employee_id = $request->employee_id;

        $advance = new ErpEmployeeAdvance();
        $advance->employee_id = $employee_id;
        $advance->amount = $request->amount;
        $advance->repay_duration = $request->repay_duration;
        $advance->monthly_repay = $request->amount / $request->repay_duration;
        $months = $advance->repay_duration;
        $advance->from_month = Carbon::now()->addMonths(1);
        $advance->to_month = Carbon::now()->addMonths($months);
        $advance->description = $request->description;
        $advance->created_by = Auth::user()->id;
        $advance->save();

        return redirect('/employee/'.$employee_id)->with('message-success', 'Advance has been added');
    }
    
    public function deleteAdvanceView($id){
        $module = 'deleteAdvance';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteAdvance($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $advance = ErpEmployeeAdvance::find($id);
        $result = $advance->delete();
        
        if($result){
            return redirect()->back()->with('message-success-delete', 'Deletion successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function addOvertimePay(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'employee_id' => 'required',
            'amount' => 'required',
        ]);
        $employee_id = $request->employee_id;

        $overtime = new ErpEmployeeOvertimePay();
        $overtime->employee_id = $employee_id;
        $overtime->project_id = $request->project_id;
        $overtime->overtime_pay_name = $request->overtime_pay_name;
        $overtime->amount = $request->amount;
        $overtime->pay_date = date('Y-m-d', strtotime($request->pay_date));
        $overtime->description = $request->description;
        $overtime->created_by = Auth::user()->id;
        $overtime->save();

        return redirect('/employee/'.$employee_id)->with('message-success', 'Overtime pay has been added');
    }
    
    public function deleteOvertimeView($id){
        $module = 'deleteOvertime';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteOvertime($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $overtime = ErpEmployeeOvertimePay::find($id);
        $result = $overtime->delete();
        
        if($result){
            return redirect()->back()->with('message-success-delete', 'Deletion successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
    
    public function addConveyancePay(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'employee_id' => 'required',
            'conveyance_id' => 'required',
        ]);
        $employee_id = $request->employee_id;
    
        $conveyance = new ErpEmployeeConveyance();
        $conveyance->employee_id = $employee_id;
        $conveyance->conveyance_id = $request->conveyance_id;
        $conveyance->project_id = $request->project_id;
        if ($request->amount != null)
            $conveyance->amount = $request->amount;
        $conveyance->pay_date = date('Y-m-d', strtotime($request->pay_date));
        $conveyance->description = $request->description;
        $conveyance->created_by = Auth::user()->id;
        $conveyance->save();
        
        return redirect('/employee/'.$employee_id)->with('message-success', 'Conveyance pay has been added');
    }
    
    public function deleteConveyanceView($id){
        $module = 'deleteConveyance';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteConveyance($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $conveyance = ErpEmployeeConveyance::find($id);
        $result = $conveyance->delete();
        
        if($result){
            return redirect()->back()->with('message-success-delete', 'Deletion successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

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
            'incentive_name'=>'required'
        ]);

        $incentive = new ErpSalaryIncentive();
        $incentive->incentive_name = $request->get('incentive_name');

        $result = $incentive->save();
        if($result) {
            return redirect('/incentive')->with('message-success', 'Incentive has been added.');
        } else {
            return redirect('/incentive')->with('message-success', 'Something went wrong.');
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
        $editData = ErpSalaryIncentive::find($id);
        return view('backEnd.employees.incentive.index', compact('editData'));
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
            'incentive_name'=>'required'
        ]);

        $incentive = ErpSalaryIncentive::find($id);
        $incentive->incentive_name = $request->get('incentive_name');

        $result = $incentive->update();
        if($result) {
            return redirect('/incentive')->with('message-success', 'Incentive has been updated.');
        } else {
            return redirect('/incentive')->with('message-success', 'Something went wrong.');
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

    public function deleteIncentiveView($id){
        $module = 'deleteIncentive';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteIncentive($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $incentive = ErpSalaryIncentive::find($id);
        $incentive->active_status = 0;

        $results = $incentive->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Incentive has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}

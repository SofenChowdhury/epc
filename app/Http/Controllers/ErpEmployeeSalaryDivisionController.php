<?php

namespace App\Http\Controllers;

use App\ErpEmployee;
use App\ErpEmployeeSalaryDivision;
use App\ErpProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpEmployeeSalaryDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = ErpEmployeeSalaryDivision::all();
        $employees = ErpEmployee::where('active_status', '=', 1)->where('employee_status', '=', 1)->get();
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.employees.salaryDivision.index', compact('divisions', 'employees', 'projects'));
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
            'employee_id' => "required",
            'project_hours' => "required",
            'total_hours' => "required",
        ]);
        return $request;
        $division = new ErpEmployeeSalaryDivision();
        $division->employee_id = $request->employee_id;
        $division->project_id = $request->project_id;
        $division->project_hours = $request->project_hours;
        $division->total_hours = $request->total_hours;
        $division->hour_percentage = $request->project_hours / $request->total_hours * 100;
        $division->created_by = Auth::user()->id;
        $results = $division->save();
    
        if($results){
            return redirect()->back()->with('message-success', 'New Salary Division has been added successfully');
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
        //
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
        //
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
    
    public function deleteSalaryDivisionView($id){
        $module = 'deleteSalaryDivision';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    
    public function deleteSalaryDivision($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $division = ErpEmployeeSalaryDivision::find($id)->delete();
        
        if($division){
            return redirect()->back()->with('message-success-delete', 'Deletion successful');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}

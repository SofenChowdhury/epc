<?php

namespace App\Http\Controllers;

use App\ErpEmployee;
use App\ErpEmployeeSalary;
use App\Http\Resources\salaryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiSalaryController extends Controller
{
    public function index($id){
        $employee=ErpEmployee::find($id);
        $some=$employee->salary()->latest()->first();
        return new salaryResource($some);
    }

    public function store(Request $request,$id){
        $salary=new ErpEmployeeSalary();
        $salary->employee_id=$id;
        $salary->total_salary=$request->new_salary;
        $salary->basic_percentage=$request->basic_percentage;
        $salary->basic=$request->basic;
        $salary->hourly_rate = ($salary->basic * 12) / 2080;
        $salary->medical_percentage=$request->medical_percentage;
        $salary->medical=$request->medical;
        $salary->provident_fund_percentage=$request->provident_fund_percentage;
        $salary->provident_fund=$request->provident_fund;
        $salary->conveyance=$request->conveyance;
        $salary->increment=$request->increment;
        $salary->increment_date=$request->increment_date;

        $salary->save();

        ErpEmployeeSalary::tax_calc($salary->id, $salary->total_salary);
    }
}

<?php

namespace App\Http\Controllers;

use App\ErpEmployee;
use App\ErpDesignation;
use App\ErpEmployeeAttendance;
use App\ErpProject;
use App\ErpTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $users = DB::table('users')
            ->join('erp_employees', 'users.employee_id', '=', 'erp_employees.id')
            ->where('users.active_status', '=', 1)
            ->select('users.id', 'users.name', 'erp_employees.employee_photo', 'erp_employees.designation_id')
            ->get();

        $designations = ErpDesignation::all();
        $projects = ErpProject::where('active_status', 1)->get();

        $attendances = ErpEmployeeAttendance::whereDay('attendance_date',Carbon::now()->day)->get();

        $total_employees = ErpEmployee::count();
        $total_projects = ErpProject::where('active_status', '=', 1)->count();
        $total_transactions = ErpTransaction::whereMonth('transaction_date',Carbon::now()->day)->count();
        $transaction_sum = ErpTransaction::whereMonth('transaction_date',Carbon::now()->day)->sum('total_transaction');
        $present_employees = ErpEmployeeAttendance::whereDay('attendance_date',Carbon::now()->day)->count();

        return view('backEnd.dashboard', compact(
            'users',
            'designations',
            'total_employees',
            'projects',
            'attendances',
            'total_projects',
            'total_transactions',
            'transaction_sum',
            'present_employees'
        ));

    }
}

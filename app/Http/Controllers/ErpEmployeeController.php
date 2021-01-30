<?php

namespace App\Http\Controllers;

use App\ErpBaseSetup;
use App\ErpChalanNo;
use App\ErpDepartment;
use App\ErpDesignation;
use App\ErpEmployee;
use App\ErpEmployeeAttendance;
use App\ErpEmployeeBank;
use App\ErpEmployeeCategory;
use App\ErpEmployeeDocument;
use App\ErpEmployeeEducation;
use App\ErpEmployeeFamily;
use App\ErpEmployeeLeave;
use App\ErpEmployeeLeaveCount;
use App\ErpEmployeeMaterial;
use App\ErpEmployeeSalary;
use App\ErpEmployeeSalaryDivision;
use App\ErpEmployeeSalaryPrint;
use App\ErpEmployeeType;
use App\ErpEmployeeWorkExperience;
use App\ErpInventory;
use App\ErpLeaveReason;
use App\ErpLeaveType;
use App\ErpLocation;
use App\ErpPayslipAuthorize;
use App\ErpProduct;
use App\ErpProject;
use App\ErpProjectEmployee;
use App\ErpRoomNo;
use App\erpSetup;
use App\ErpTask;
use App\Notifications\EmployeeAdded;
use App\Notifications\EmployeeCertificate;
use App\Notifications\LeavePermission;
use App\Notifications\LeaveRequest;
use App\Notifications\SalarySataementApprove;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Notification;
use Spatie\Permission\Models\Role;

class ErpEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Employee List|View Employee Details|View Employee Salary|View Employee Leave|View Employee Attendance History|View Employee Tasks|View Employee Document|Add as User|View Own Profile')->only('index');
        $this->middleware('permission:View Employee List|Add/Edit Employee')->only('create','edit','store','update');
        $this->middleware('permission:View Employee Details|View Employee Salary|View Employee Leave|View Employee Attendance History|View Employee Tasks|View Employee Document|View Own Profile')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = ErpEmployee::where('active_status', '=', 1)->get();
//        $employees = ErpEmployee::where('active_status', '=', 1)->orderBy('unique_id')->get();
        $roles = Role::all();
        return view('backEnd.employees.employee.index', compact('employees', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $departments = ErpDepartment::all();
        $designations = ErpDesignation::all();
        $types = ErpEmployeeType::all();
        $employee_categories = ErpEmployeeCategory::where('active_status', '=', 1)->get();
        $genders = ErpBaseSetup::where('base_group_id', '=', 1)->get();
        $blood_groups = ErpBaseSetup::where('base_group_id', '=', 2)->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $locations = ErpLocation::all();
        $rooms = ErpRoomNo::all();
        return view('backEnd.employees.employee.create', compact('designations','departments', 'types', 'employee_categories', 'genders','blood_groups', 'projects', 'rooms', 'locations'));
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
            'first_name' => 'required|string|min:1|max:150',
            'last_name' => 'required',
            'unique_id' => 'required|unique:erp_employees,unique_id,' . $request->get('unique_id'),
            'email' => 'required|unique:erp_employees,email,' . $request->get('email'),
            'date_of_birth' => 'required',
            'joining_date' => 'required',
            'mobile' => 'required',
            'employee_type' => 'required',
            'employee_category'=>'required',
            'place_of_birth' => 'required',
            'nid' => 'required| unique:erp_employees,nid,' . $request->get('nid'),
            'tin' => 'required| unique:erp_employees,tin,' . $request->get('tin'),
            'department_id' => 'required',
            'designation_id' => 'required',
            'gender_id' => 'required',
            'blood_group_id'=> 'required',
            'current_address'=> 'required',
            'epc_before' => 'required',
            'relative' => 'required',

            'employee_photo' => 'image|mimes:jpeg,jpg,png|max:2048',
            'joining_letter' => 'mimes:pdf',

            'father_name'=> 'required',
            'mother_name'=> 'required',
            'marital_status'=> 'required',
        ]);

        $employee = new ErpEmployee();
        $employee->first_name = $request->get('first_name');
        $employee->last_name = $request->get('last_name');
        $employee->unique_id = $request->get('unique_id');
        $employee->email = $request->get('email');
        $employee->mobile = $request->get('mobile');
        $employee->emergency_no = $request->get('emergency_no');
        if($request->date_of_birth != null){
            $employee->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        }
        $employee->permanent_address = $request->get('permanent_address');
        $employee->current_address = $request->get('current_address');
        $employee->place_of_birth = $request->get('place_of_birth');
        $employee->nid = $request->get('nid');
        $employee->tin = $request->get('tin');
        $employee->department_id = $request->get('department_id');
        $employee->designation_id = $request->get('designation_id');
        $employee->supervisor_designation = $request->get('supervisor_designation');
        $employee->location = $request->get('location');
        $employee->room_no = $request->get('room_no');
        $employee->employee_type = $request->get('employee_type');
        $employee->employee_category_id = $request->get('employee_category');
        if($request->probation_period != null){
            $employee->probation_period = date('Y-m-d', strtotime($request->probation_period));
        }
        if($request->joining_date != null){
            $employee->joining_date = date('Y-m-d', strtotime($request->joining_date));
        }
        if ($request->hasFile('joining_letter')) {
            $joining_letter = $request->file('joining_letter');
            $joining_letter_name = time() . $joining_letter->getClientOriginalName();
            $destinationPath = public_path('/uploads/joining_letter');
            $joining_letter->move($destinationPath, $joining_letter_name);
            $employee->joining_letter = '/uploads/joining_letter/'.$joining_letter_name;
        }
        if ($request->hasFile('employee_photo')) {
            $image = $request->file('employee_photo');
            $image_name = time() . $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/employee_img');
            $image->move($destinationPath, $image_name);
            $employee->employee_photo = '/public/uploads/employee_img/'.$image_name;
        }
        $employee->gender_id = $request->get('gender_id');
        $employee->blood_group_id = $request->get('blood_group_id');
        $employee->qualifications = $request->get('qualifications');
        $employee->experiences = $request->get('experiences');
        $employee->created_by = Auth::user()->id;

        $employee->save();

        $employee_id = $employee->id;

        //FOR QUALIFICATION DOCUMENTS IN EMP_EDUCATION TABLE
        if($request->hasFile('qualification_docs') && !empty($employee_id)) {
            $allowedfileExtension=['pdf', 'png', 'jpg', 'jpeg'];
            $files = $request->file('qualification_docs');
            foreach($files as $file) {
                $filename = time() . $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array( $extension, $allowedfileExtension );

                if($check) {
                    $document = new ErpEmployeeEducation();
                    $document->employee_id = $employee_id;
                    $document->created_by = Auth::user()->id;

                    $destinationPath = public_path('/uploads/qualifications');
                    $file->move($destinationPath, $filename);
                    $document->upload_document = '/uploads/qualifications/'.$filename;

                    $document->save();
                }
            }
        }

        //FOR EXPERIENCE DOCUMENTS IN EMP_WORK_EXPERIENCE TABLE
        if($request->hasFile('experience_docs') && !empty($employee_id)) {
            $allowedfileExtension=['pdf', 'png', 'jpg', 'jpeg'];
            $files = $request->file('experience_docs');
            foreach($files as $file) {
                $filename = time() . $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array( $extension, $allowedfileExtension );

                if($check) {
                    $document = new ErpEmployeeWorkExperience();
                    $document->employee_id = $employee_id;
                    $document->created_by = Auth::user()->id;

                    $destinationPath = public_path('/uploads/work_experience');
                    $file->move($destinationPath, $filename);
                    $document->upload_document = '/uploads/work_experience/'.$filename;

                    $document->save();
                }
            }
        }

        if(!empty($employee_id)) {

            //FOR EMPLOYEE FAMILY IN EMP_FAMILY TABLE
            $family = new ErpEmployeeFamily();
            $family->employee_id = $employee_id;
            $family->father_name = $request->get('father_name');
            $family->mother_name = $request->get('mother_name');
            $family->marital_status = $request->get('marital_status');
            $family->spouse_name = $request->get('spouse_name');
            $family->child_name = $request->get('child_name');
            $family->epc_before = $request->get('epc_before');
            if($request->epc_before == 1){
                $family->epc_before_from = date('Y-m-d', strtotime($request->epc_before_from));
                $family->epc_before_to = date('Y-m-d', strtotime($request->epc_before_to));
            }
            $family->relative = $request->get('relative');
            $family->relative_name = $request->get('relative_name');
            $family->created_by = Auth::user()->id;
            $family_result = $family->save();

            //FOR EMPLOYEE BANK
            $bank = new ErpEmployeeBank();
            $bank->employee_id = $employee_id;
            $bank->bank_name = $request->get('bank_name');
            $bank->account_number = $request->get('account_number');
            $bank->bank_branch = $request->get('bank_branch');
            $bank->bank_address = $request->get('bank_address');
            $bank->routing_no = $request->get('routing_no');
            $bank->swift_code = $request->get('swift_code');
            $bank->checking_savings = $request->get('checking_savings');
            $bank->created_by = Auth::user()->id;
            $bank_result = $bank->save();

            //FOR EMPLOYEE SALARY
            $salary = new ErpEmployeeSalary();
            $salary->employee_id = $employee_id;
            $salary->total_salary = $request->get('total_salary');
            $salary->basic_percentage = $request->basic_percentage;
            $salary->basic = $request->basic;
            $salary->hourly_rate = ($salary->basic * 12) / 2080;
            $salary->provident_fund_percentage = $request->provident_fund_percentage;
            $salary->provident_fund = $request->provident_fund;
            $salary->medical_percentage = $request->medical_percentage;
            $salary->medical = $request->medical;
            $salary->conveyance = $request->conveyance;
            $salary->tax_amount = $request->get('tax_amount');
            $salary->tax_payable = $request->tax_payable;
            $salary->created_by = Auth::user()->id;

            $salary_result = $salary->save();

            if($family_result && $bank_result && $salary_result){

                $hr_admins = User::role('HR Admin')->get();
                foreach ($hr_admins as $user) {
                    Notification::send($user, new EmployeeAdded($employee));
                }

                return redirect('/employee')->with('message-success', 'Employee has been added successfully.');
            } else {
                return redirect('/employee')->with('message-danger', 'Something went wrong');
            }
        } else {
            return redirect('/employee')->with('message-danger', 'Something went wrong');
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
        $editData = ErpEmployee::find($id);
        $this_user = User::where('employee_id', '=', $id)->first();

        if($this_user == null ){
            $this_user_id = 0;
        } else{
            $this_user_id = $this_user->id;
        }

        $genders = ErpBaseSetup::where('base_group_id', '=', 1)->where('active_status','=',1)->get();
        $blood_groups = ErpBaseSetup::where('base_group_id', '=', 2)->where('active_status','=',1)->get();

        $users = User::all();

        $month = Carbon::now()->format('F , Y');
        $salary = ErpEmployeeSalary::tax_certificate($id, $month, $month, 1);

        $leave_types = ErpLeaveType::all();
        $leave_reasons = ErpLeaveReason::all();
        $leaves = ErpEmployeeLeave::where('employee_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        $attendances = ErpEmployeeAttendance::where('employee_id', '=', $id)->whereMonth('attendance_date',Carbon::now()->month)->orderBy('attendance_date')->get();
        $tasks = ErpTask::where('assigned_to', '=', $this_user_id)->where('active_status','=',1)->orderBy('created_at', 'DESC')->get();
        $documents = ErpEmployeeDocument::where('employee_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        $experiences = ErpEmployeeWorkExperience::where('employee_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $projects_involved = ErpProjectEmployee::where('employee_id', $id)->distinct('project_id')->get(['project_id']);
        $employees = ErpEmployee::all();
        $products = ErpProduct::all();

        $month = Carbon::now()->format('F Y');
//        $setup = ErpSetup::latest()->first();

        return view('backEnd.employees.employee.show', compact('editData',
            'genders',
            'blood_groups',
            'users',
            'salary',
            'leave_types',
            'leave_reasons',
            'leaves',
            'attendances',
            'tasks',
            'documents',
            'experiences',
            'projects',
            'projects_involved',
            'employees',
            'products',
            'month'
//            'setup'
        ));
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
        $editData = ErpEmployee::find($id);
        $designations = ErpDesignation::where('active_status','=',1)->get();
        $departments = ErpDepartment::where('active_status','=',1)->get();
        $types = ErpEmployeeType::all();
        $employee_categories = ErpEmployeeCategory::where('active_status', '=', 1)->get();
        $genders = ErpBaseSetup::where('base_group_id', '=', 1)->where('active_status','=',1)->get();
        $blood_groups = ErpBaseSetup::where('base_group_id', '=', 2)->where('active_status','=',1)->get();
        $salary = ErpEmployeeSalary::where('employee_id','=',$id)->latest()->first();
//        $setup = ErpSetup::latest()->first();
        $locations = ErpLocation::all();
        $rooms = ErpRoomNo::all();
        $projects = ErpProject::where('active_status', 1)->get();

        return view('backEnd.employees.employee.edit', compact('editData','designations','departments', 'types', 'employee_categories','genders','blood_groups', 'salary', 'rooms', 'locations', 'projects'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'unique_id' => ['required',
                Rule::unique('erp_employees', 'unique_id')->ignore($id, 'id')
            ],
            'email' => ['required',
                Rule::unique('erp_employees', 'email')->ignore($id, 'id')
            ],

//            'email'=> 'required'
        ]);

        $employee = ErpEmployee::find($id);
        $employee->first_name = $request->get('first_name');
        $employee->last_name = $request->get('last_name');
        $employee->unique_id = $request->get('unique_id');
        $employee->mobile = $request->get('mobile');
        $employee->emergency_no = $request->get('emergency_no');
        $employee->email = $request->get('email');
        $employee->employee_status = $request->get('employee_status');
        $employee->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $employee->permanent_address = $request->get('permanent_address');
        $employee->current_address = $request->get('current_address');
        $employee->place_of_birth = $request->get('place_of_birth');
        $employee->nid = $request->get('nid');
        $employee->tin = $request->get('tin');
        $employee->department_id = $request->get('department_id');
        $employee->designation_id = $request->get('designation_id');
        $employee->supervisor_designation = $request->get('supervisor_designation');
        $employee->location = $request->get('location');
        $employee->room_no = $request->get('room_no');
        $employee->employee_type = $request->get('employee_type');
        $employee->employee_category_id = $request->get('employee_category');
        $employee->joining_date = date('Y-m-d', strtotime($request->joining_date));
        if ($request->hasFile('employee_photo')) {
            $image = $request->file('employee_photo');
            $image_name = time() . $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/employee_img');
            $image->move($destinationPath, $image_name);
            $employee->employee_photo = '/public/uploads/employee_img/'.$image_name;
        }
        $employee->gender_id = $request->get('gender_id');
        $employee->blood_group_id = $request->get('blood_group_id');
        $employee->qualifications = $request->get('qualifications');
        $employee->experiences = $request->get('experiences');
        $employee->updated_by = Auth::user()->id;

        $family = ErpEmployeeFamily::where('employee_id','=',$id)->first();
        $family->father_name = $request->get('father_name');
        $family->mother_name = $request->get('mother_name');
        $family->marital_status = $request->get('marital_status');
        $family->spouse_name = $request->get('spouse_name');
        $family->child_name = $request->get('child_name');
        $family->epc_before = $request->get('epc_before');
        if($request->epc_before == 1){
            $family->epc_before_from = date('Y-m-d', strtotime($request->epc_before_from));
            $family->epc_before_to = date('Y-m-d', strtotime($request->epc_before_to));
        }
        $family->relative = $request->get('relative');
        $family->relative_name = $request->get('relative_name');
        $family->updated_by = Auth::user()->id;

        $bank = ErpEmployeeBank::where('employee_id','=',$id)->first();
        $bank->bank_name = $request->get('bank_name');
        $bank->account_number = $request->get('account_number');
        $bank->bank_branch = $request->get('bank_branch');
        $bank->bank_address = $request->get('bank_address');
        $bank->routing_no = $request->get('routing_no');
        $bank->swift_code = $request->get('swift_code');
        $bank->checking_savings = $request->get('checking_savings');
        $bank->updated_by = Auth::user()->id;

        $salary = ErpEmployeeSalary::where('employee_id','=',$id)->latest()->first();
        $salary->total_salary = $request->get('total_salary');
        $salary->basic_percentage = $request->basic_percentage;
        $salary->basic = $request->basic;
        $salary->provident_fund_percentage = $request->provident_fund_percentage;
        $salary->provident_fund = $request->provident_fund;
        $salary->medical_percentage = $request->medical_percentage;
        $salary->medical = $request->medical;
        $salary->conveyance = $request->conveyance;
        $salary->tax_amount = $request->get('tax_amount');
        $salary->tax_payable = $request->tax_payable;
        $salary->updated_by = Auth::user()->id;

        $user = User::where('employee_id','=',$id)->first();
        if($user){
            $user->name = $employee->first_name." ".$employee->last_name;
            $user->update();
        }

        $employee_results = $employee->update();
        $family_result = $family->update();
        $bank_result = $bank->update();
        $salary_result = $salary->update();

        if($employee_results && $family_result && $bank_result && $salary_result) {
            return redirect('/employee')->with('message-success', 'Employee has been updated');
        } else {
            return redirect('/employee')->with('message-danger', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployeeView($id){
        $module = 'deleteEmployee';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteEmployee($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $employee = ErpEmployee::find($id);
        $employee->active_status = 0;
        $results = $employee->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Employee has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function printInfo($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $editData = ErpEmployee::find($id);
        $genders = ErpBaseSetup::where('base_group_id', '=', 1)->where('active_status','=',1)->get();
        $blood_groups = ErpBaseSetup::where('base_group_id', '=', 2)->where('active_status','=',1)->get();
        $users = User::all();
//        $setup = ErpSetup::latest()->first();
        return view('backEnd.employees.printStatement.print', compact('editData', 'genders','blood_groups', 'users'));
    }

    public function salaryStatement()
    {
        $salary_month =  Carbon::now()->format('Y-m-d');

        $employees = ErpEmployee::where('employee_status', '=', 1)
            ->where('active_status', '=', 1)
            ->whereNotIn('id',
                (ErpProjectEmployee::select('employee_id')
                    ->where('employee_id', '!=', null)
                    ->where('project_phase', '>', 2)
                    ->whereNotIn('employee_id', ErpEmployeeSalaryDivision::select('employee_id')->where('project_id', '=', 0)->get()->toArray())
                    ->get()
                )->toArray()
            )
            ->orderBy('unique_id')
            ->distinct('id')
            ->get();

        $project_selected = 0;
        $projects = ErpProject::where('active_status', 1)->get();
        $salaries = ErpEmployeeSalary::whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
        $approver = ErpEmployeeSalaryPrint::whereMonth('salary_month',Carbon::now()->month)->where('project_id', 0)->latest()->first();
//        $setup = ErpSetup::latest()->first();
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
//        dd($authorizes);
        $activeDiv = 0;
        return view('backEnd.employees.printStatement.index', compact('salary_month', 'employees', 'project_selected', 'projects', 'salaries', 'approver', 'authorizes','activeDiv'));
    }

    public function salaryStatementDate(Request $request)
    {
        if (isset($request->salary_month)){
            $salary_month =  date('Y-m-d', strtotime($request->salary_month));
        } else{
            $salary_month =  date('Y-m-d', strtotime($request->auto_date));
        }

        if ($request->project_id == 0){
            $employees = ErpEmployee::where('employee_status', '=', 1)
                ->where('active_status', '=', 1)
                ->whereNotIn('id',
                    (ErpProjectEmployee::select('employee_id')
                        ->where('employee_id', '!=', null)
                        ->where('project_phase', '>', 2)
                        ->whereNotIn('employee_id', ErpEmployeeSalaryDivision::select('employee_id')->where('project_id', '=', 0)->get()->toArray())
                        ->get()
                        )->toArray()
                    )
                ->orderBy('unique_id')
                ->distinct('id')
                ->get();
        } else{
            $employees = ErpEmployee::leftJoin('erp_project_employees as project_emp', function($join) {
                $join->on('project_emp.employee_id', '=', 'erp_employees.id')->where('project_emp.project_phase', '>', 2);
            })
                ->where('project_emp.project_id', $request->project_id)
                ->where('erp_employees.employee_status', '=', 1)
                ->where('erp_employees.active_status', '=', 1)
                ->where('project_emp.active_status', 1)
                ->orderBy('unique_id')
                ->distinct('erp_employees.id')
                ->get(['erp_employees.*']);
        }
//        dd($employees);
        $project_selected = $request->project_id;
        $projects = ErpProject::where('active_status', 1)->get();
        $salaries = ErpEmployeeSalary::whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
        $approver = ErpEmployeeSalaryPrint::where('salary_month', 'like',  date('Y-m', strtotime($salary_month)) . '%')->where('project_id', $request->project_id)->latest()->first();
//        $setup = ErpSetup::latest()->first();
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
        $activeDiv = $request->active_div;
        return view('backEnd.employees.printStatement.index', compact('salary_month', 'employees', 'project_selected', 'projects', 'salaries', 'approver', 'authorizes', 'activeDiv'));
    }

    public function salaryStatementApprove(Request $request)
    {
        if ($request->new_statement == 1){
            $statement = new ErpEmployeeSalaryPrint();
            $statement->salary_month = date('Y-m-d', strtotime($request->salary_month));
            $statement->project_id = $request->project_id;
            if ($request->permission == 1){
                $statement->approval_level = 1;
                $statement->next_user_id = 24;
                $user = User::find(24);
                Notification::send($user, new SalarySataementApprove($statement));
            }

            $statement->save();
        } else{
            $statement = ErpEmployeeSalaryPrint::where('salary_month', 'like',  date('Y-m', strtotime($request->salary_month)) . '%')->where('project_id', $request->project_id)->latest()->first();
            if ($request->permission == 1){
                $statement->approval_level++;
                if ($statement->approval_level == 1){
                    $statement->next_user_id = 24;
                    $user = User::find(24);
                    Notification::send($user, new SalarySataementApprove($statement));
                } else if ($statement->approval_level == 2){
                    $statement->next_user_id = 23;
                    $user = User::find(23);
                    Notification::send($user, new SalarySataementApprove($statement));
                } else if ($statement->approval_level == 3){
                    $statement->next_user_id = 21;
                    $user = User::find(21);
                    Notification::send($user, new SalarySataementApprove($statement));
                }else if ($statement->approval_level == 4){
                    $statement->next_user_id = 20;
                    $user = User::find(20);
                    Notification::send($user, new SalarySataementApprove($statement));
                } else if ($statement->approval_level == 5){
                    $statement->next_user_id = 19;
                    $user = User::find(19);
                    Notification::send($user, new SalarySataementApprove($statement));
                }
            } else if ($request->permission == 0) {
                $statement->approval_level = 0;
                $statement->next_user_id = 1;
            }
            $statement->update();
        }
        return redirect('salary_statement');
    }

    public function printSalaryStatement(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $salary_month =  date('d-m-Y', strtotime($request->salary_month));

        $project = ErpProject::find($request->project_id);
        if ($project){
            $project_name = $project->project_name;
            $project_id = $project->id;
        }
        else{
            $project_name = 'Head Office';
            $project_id = 0;
        }

        if ($request->project_id == 0){
            $employees = ErpEmployee::where('employee_status', '=', 1)
                ->where('active_status', '=', 1)
                ->whereNotIn('id',
                    (ErpProjectEmployee::select('employee_id')
                        ->where('employee_id', '!=', null)
                        ->where('project_phase', '>', 2)
                        ->whereNotIn('employee_id', ErpEmployeeSalaryDivision::select('employee_id')->where('project_id', '=', 0)->get()->toArray())
                        ->get()
                        )->toArray()
                    )
                ->orderBy('unique_id')
                ->distinct('id')
                ->get();
        } else{
            $employees = ErpEmployee::leftJoin('erp_project_employees as project_emp', function($join) {
                $join->on('project_emp.employee_id', '=', 'erp_employees.id')->where('project_emp.project_phase', '>', 2);
            })
                ->where('project_emp.project_id', $request->project_id)
                ->where('project_emp.active_status', 1)
                ->orderBy('unique_id')
                ->distinct('erp_employees.id')
                ->get(['erp_employees.*']);
        }
        $salaries = ErpEmployeeSalary::whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
//        $setup = ErpSetup::latest()->first();
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
        return view('backEnd.employees.printStatement.printSalary', compact('salary_month', 'employees', 'project_name', 'project_id', 'salaries', 'authorizes'));
    }

    public function printSalaryAdvice(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $salary_month =  date('d-m-Y', strtotime($request->salary_month));
        $project = ErpProject::find($request->project_id);
        if ($project){
            $project_name = $project->project_name;
            $project_id = $project->id;
        }
        else{
            $project_name = 'Head Office';
            $project_id = 0;
        }
        if ($request->project_id == 0){
            $employees = ErpEmployee::where('employee_status', '=', 1)
                ->where('active_status', '=', 1)
                ->whereNotIn('id',
                    (ErpProjectEmployee::select('employee_id')
                        ->where('employee_id', '!=', null)
                        ->where('project_phase', '>', 2)
                        ->whereNotIn('employee_id', ErpEmployeeSalaryDivision::select('employee_id')->where('project_id', '=', 0)->get()->toArray())
                        ->get()
                        )->toArray()
                    )
                ->orderBy('unique_id')
                ->distinct('id')
                ->get();
        } else{
            $employees = ErpEmployee::leftJoin('erp_project_employees as project_emp', function($join) {
                $join->on('project_emp.employee_id', '=', 'erp_employees.id')->where('project_emp.project_phase', '>', 2);
            })
                ->where('project_emp.project_id', $request->project_id)
                ->where('project_emp.active_status', 1)
                ->orderBy('unique_id')
                ->distinct('erp_employees.id')
                ->get(['erp_employees.*']);
        }
        $salaries = ErpEmployeeSalary::whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
//        $setup = ErpSetup::latest()->first();
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
        return view('backEnd.employees.printStatement.printSalaryBank', compact( 'salary_month', 'project_name', 'project_id', 'employees', 'salaries', 'authorizes'));
    }

    public function printCertificate($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $employee = ErpEmployee::find($id);
        $max = ErpEmployee::max('emp_certificate');
        $employee->emp_certificate = $max+1;
        $employee->update();

        $user = User::find(1);
        Notification::send($user, new EmployeeCertificate($employee));

        $salary = ErpEmployeeSalary::where('employee_id','=',$id)->latest()->first();
//        $setup = ErpSetup::latest()->first();
        return view('backEnd.employees.printStatement.printCertificate', compact('employee', 'salary'));
    }

    public function printSalaryIndividual($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $employee = ErpEmployee::find($id);
        $chalans = ErpChalanNo::all();
//        $setup = ErpSetup::latest()->first();
        $month = Carbon::now()->format('F , Y');
        $start_month =  Carbon::now()->format('F, Y');
        $end_month =  Carbon::now()->format('F, Y');
        $result = ErpEmployeeSalary::tax_certificate($id, $start_month, $end_month, 1);
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
        return view('backEnd.employees.printStatement.taxCertificate', compact('employee', 'month', 'result', 'chalans', 'authorizes'));
    }

    public function printSalaryMonth(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $employee = ErpEmployee::find($id);
        $start_month =  date('F, Y', strtotime($request->start_month));
        $end_month =  date('F, Y', strtotime($request->end_month));
        $result = ErpEmployeeSalary::tax_certificate($id, $start_month, $end_month, 1);
        $chalans = ErpChalanNo::all();
//        $setup = ErpSetup::latest()->first();
        $authorizes = ErpPayslipAuthorize::orderBy('serial_no')->get();
        return view('backEnd.employees.printStatement.taxCertificate', compact('employee', 'start_month', 'end_month', 'result', 'chalans', 'authorizes'));
    }

    public function leaveRequest(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'leaved','path'=>url()->current())
        );
        $request->validate([
            'type_of_leave'=>'required',
            'start_date'=> 'required',
            'end_date'=> 'required',
        ]);

        $employee = ErpEmployee::find($id);
//        dd($employee);
        $leave_count = ErpEmployeeLeaveCount::where('employee_id', $id)->where('leave_type_id', $request->type_of_leave)->latest()->first();
        $total_days = date('d', strtotime($request->end_date) - strtotime($request->start_date));

        $type = ErpLeaveType::find($request->type_of_leave);
        $start = date('d-m-Y',strtotime($request->start_date));
        $now = Carbon::now()->format('d-m-Y');
        $prior = date('d', strtotime($start) - strtotime($now));

        if($leave_count && ($leave_count->count + $total_days) >= $type->total_leaves) {
            return redirect()->back()->with('message-danger', 'Sorry, you have applied for more than your allotted ' . $leave_count->leave->leave_type);
        } elseif($request->type_of_leave == 2 && $total_days >= 7 && $prior < 14){
            return redirect()->back()->with('message-danger', 'Sorry, you have to apply at least 14 days prior for '. $total_days . ' days of ' . $type->leave_type);
        } elseif($request->type_of_leave == 2 && $total_days <= 7 && $prior < 7){
            return redirect()->back()->with('message-danger', 'Sorry, you have to apply at least 7 days prior for '. $total_days . ' days of ' .  $type->leave_type);
        } elseif($request->type_of_leave == 4 && $prior < 14){
            return redirect()->back()->with('message-danger', 'Sorry, you have to apply at least 14 days prior for '. $type->leave_type);
        } else {
            $leave = new ErpEmployeeLeave();
            $self = true;
            $leave->employee_id = $id;
            $leave->type_of_leave = $request->get('type_of_leave');
            $leave->start_date = date('Y-m-d', strtotime($request->start_date));
            $leave->end_date = date('Y-m-d', strtotime($request->end_date));
            $leave->total_days = $total_days;
//            $leave->approved_by = $request->get('approved_by');
            if ($leave->type_of_leave == 1) {
                $leave->description = $request->get('reason');
            } else
                $leave->description = $request->get('description');
            $leave->created_by = Auth::user()->id;

            if ($request->hasFile('leave_document')) {
                $document = $request->file('leave_document');
                $document_name = time() . $document->getClientOriginalName();
                $destinationPath = public_path('/uploads/leave_request');
                $document->move($destinationPath, $document_name);
                $leave->leave_document = '/uploads/leave_document/' . $document_name;
                $hr_admin = User::role('HR Admin')->latest()->first();
                $leave->approved_by = $hr_admin->id;
                $leave->approved_by = Auth::user()->id;
                $self = false;
                $leave_count = ErpEmployeeLeaveCount::where('employee_id', $id)->where('leave_type_id', $request->type_of_leave)->latest()->first();
                if ($leave_count) {
                    $leave_count->count += $leave->total_days;
                    $leave_count->update();
                } else {
                    $count = new ErpEmployeeLeaveCount();
                    $count->employee_id = $leave->employee_id;
                    $count->leave_type_id = $leave->type_of_leave;
                    $count->count = $leave->total_days;
                    $count->save();
                }
                $leave->approval_status = 1;
            }
            $result = $leave->save();

            if ($self){
                $user = User::find($leave->approved_by);
                Notification::send($user, new LeaveRequest($employee));
            }

            $hr_admins = User::role('HR Admin')->get();
            foreach ($hr_admins as $user) {
                Notification::send($user, new LeaveRequest($employee));
            }

            $designation = $employee->supervisor_designation;
            $supervisors = ErpEmployee::where('designation_id', $designation)->get();
            foreach ($supervisors as $supervisor) {
                $user = User::where('employee_id', $supervisor->id)->latest()->first();
                if ($user)
                    Notification::send($user, new LeaveRequest($employee));
            }

            if ($result) {
                return redirect()->back()->with('message-success', 'Leave request has been submitted.');
            } else {
                return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
            }
        }
    }

    public function leavePermission(Request $request, $id)
    {
        $permission = ErpEmployeeLeave::find($id);

        if($request->permission == 'approve'){
            $permission->approval_status = 1;
            $leave_count = ErpEmployeeLeaveCount::where('employee_id', $permission->employee_id)->where('leave_type_id', $permission->type_of_leave)->latest()->first();
            if($leave_count){
                $leave_count->count += $permission->total_days;
                $leave_count->update();
            } else{
                $count = new ErpEmployeeLeaveCount();
                $count->employee_id = $permission->employee_id;
                $count->leave_type_id = $permission->type_of_leave;
                $count->count = $permission->total_days;
                $count->save();
            }
        } else {
            $permission->approval_status = 2;
        }
        $permission->updated_by = $permission->approved_by;

        $leave_permission = $permission->update();

        $user = User::where('employee_id', '=', $permission->employee_id)->get();
        Notification::send($user, new LeavePermission($permission));

        if($leave_permission) {
            return redirect()->back()->with('message-success', 'Approval Status of the leave request has been updated');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function viewAttendance()
    {
        $employees = ErpEmployee::where('active_status', 1)->get();
        $attendances = ErpEmployeeAttendance::whereDay('attendance_date',Carbon::now()->day)->get();
        $month = Carbon::now()->format('F d, Y');
        return view('backEnd.employees.employee.attendance', compact( 'employees','attendances', 'month'));
    }

    public function addAttendance(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'attendance_date'=>'required',
            'in_time'=> 'required',
            'out_time'=> 'required',
        ]);
        if ($id == 0){
            $employee_id = $request->employee_id;
        } else{
            $employee_id = $id;
        }
        $attendance = new ErpEmployeeAttendance();
        $attendance->employee_id = $employee_id;
        $attendance->attendance_date = date('Y-m-d', strtotime($request->attendance_date));

        $in_time = Carbon::parse($request->in_time);
        $out_time = Carbon::parse($request->out_time);
        $total_hours = $out_time->diff($in_time);
        $total_minutes = $out_time->diffInMinutes($in_time);

        $attendance->in_time = $in_time->format('H:i');
        $attendance->out_time = $out_time->format('H:i');
        $attendance->total_hours = $total_hours->h.':'.$total_hours->i;
        if ($total_minutes > 480){
            $overt = $total_minutes - 480;
            $hrs = floor($overt / 60);
            $mins = $total_minutes % 60;
            $attendance->overtime = $hrs.':'.$mins;
        }
        $attendance->created_by = Auth::user()->id;
        $result = $attendance->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Attendance has been added.');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function salary($id) {
        $types = ErpEmployeeType::all();
        $editData = ErpEmployee::find($id);
        $designations = ErpDesignation::where('active_status','=',1)->get();
        $departments = ErpDepartment::where('active_status','=',1)->get();
        return view('backEnd.employees.employee.salary',compact('id','editData','designations','departments','types'));
    }

    public function assignMaterial(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'assigned','path'=>url()->current())
        );
        $request->validate([
            'employee_id' => 'required',
            'quantity' => 'required',
        ]);

        $material = ErpEmployeeMaterial::find($id);
        $product = ErpInventory::where('id', $material->inventory_id)->first();

        if ($request->quantity > $material->quantity){
            return redirect('/employee/'.$material->employee_id)->with('message-danger', 'You cannot assign more that available quantity.');
        } else{
            if($request->employee_id == 'inventory'){
                $product->quantity += $request->quantity;
                $product->updated_by =  Auth::user()->id;
                $product->update();
            } else{
                $employee_material = new ErpEmployeeMaterial();
                $employee_material->inventory_id = $product->id;
                $employee_material->employee_id = $request->employee_id;
                $employee_material->product_name = $product->product_name;
                $employee_material->quantity = $request->quantity;
                $employee_material->created_by =  Auth::user()->id;
                $employee_material->save();
            }

            $material->quantity -= $request->quantity;
            $material->updated_by =  Auth::user()->id;
            $material->update();

            return redirect('/employee/'.$material->employee_id)->with('message-success', 'Product has been assigned successfully.');
        }
    }

}

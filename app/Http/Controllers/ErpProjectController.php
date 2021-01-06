<?php

namespace App\Http\Controllers;

use App\ErpChartOfAccounts;
use App\ErpClient;
use App\ErpEmployee;
use App\ErpEmployeeSalary;
use App\ErpInventory;
use App\ErpProduct;
use App\ErpProject;
use App\ErpProjectAdvances;
use App\ErpProjectBudget;
use App\ErpProjectChecklist;
use App\ErpProjectComponent;
use App\ErpProjectDeliverable;
use App\ErpProjectDocument;
use App\ErpProjectEmployee;
use App\ErpProjectJointVenture;
use App\ErpProjectLesson;
use App\ErpProjectMaterial;
use App\ErpProjectPayment;
use App\ErpProjectPhase;
use App\ErpProjectPhaseDetail;
use App\ErpProjectProgressPayment;
use App\ErpProjectReporting;
use App\ErpProjectSignoff;
use App\ErpProjectTodo;
use App\ErpProjectType;
use App\erpSetup;
use App\ErpStatus;
use App\ErpTask;
use App\Notifications\InventoryRequired;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view Project List|view Project Details|view Project Payment|view Project Documents|Add/Edit Project|Add Task')->only('index');
        $this->middleware('permission:view Project List|Add/Edit Project')->only('create', 'edit', 'store', 'update');
        $this->middleware('permission:view Project Details|view Project Payment|view Project Documents|Add Task|View Task')->only('show');
    }

    public function index()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.index', compact('projects'));
    }

    public function pastProjects()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.pastProjects', compact('projects'));
    }

    public function completedProjects()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.completedProjects', compact('projects'));
    }

    public function printProjects()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.printProjects', compact('projects'));
    }

    public function printProjectsPast()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.printProjectsPast', compact('projects'));
    }

    public function printProjectsActive()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.printProjectsActive', compact('projects'));
    }

    public function printProjectsComplete()
    {
        $projects = ErpProject::where('active_status', '=', 1)->get();
        return view('backEnd.projects.printProjectsComplete', compact('projects'));
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
        $phases = ErpProjectPhase::where('required', '=', 1)->orderBy('defined_id')->get();
        $clients = ErpClient::where('active_status', '=', '1')->get();
        $users = User::where('active_status', '=', '1')->where('id', '!=', '5')->get();
        $components = ErpProjectComponent::all();
        $statuses = ErpStatus::all();
        $types = ErpProjectType::all();
        return view('backEnd.projects.create', compact('phases', 'clients', 'users', 'components','statuses', 'types'));
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
            'project_code' => 'required',
            'project_phase' => 'required',
            'contract_type' => 'required',
            'epc_lead' => 'required_if:project_type,1',
            'project_name' => 'required|string|min:3|max:150',
            'project_full_name' => 'required',
            'procuring_entity' => 'min:0|max:250',
            'procuring_entity_district' => 'min:0|max:100',
            'procurement_entity_code' => 'min:0|max:200',
            'eoi_reference' => 'min:0|max:100',
            'eoi_selection' => 'min:0|max:250',
            'procurement_method' => 'min:0|max:250',
            'programme_code' => 'min:0|max:100',
            'programme_name' => 'min:0|max:150',
            'contact_person' => 'required|min:0|max:100',
            'designation' => 'min:0|max:100',
            'contact_person_phone' => 'min:0|max:100',
            'contact_person_email' => 'min:0|max:100',
            'execution_authority' => 'min:0|max:250',
            'project_source' => 'min:0|max:150',
            'project_status' => 'required',
            'eoi_publication_date' => 'required',
            'client_id' => 'required',
        ]);
//            'eoi_due_date' => 'after:eoi_publication_date',

        $project = new ErpProject();
        $project->project_code = $request->get('project_code');
        $project->project_phase = $request->get('project_phase');
        $project->contract_type = $request->get('contract_type');
        $project->project_component = $request->get('project_component');
        if ($request->project_type){
            $type = implode(",", $request->get('project_type'));
            $project->project_type = $type;
        }
        if ($project->contract_type == 1) {
            $project->epc_share_percentage = $request->get('epc_share_percentage');
            $project->epc_lead = $request->get('epc_lead');
        }
        $project->project_full_name = $request->get('project_full_name');
        $project->project_name = $request->get('project_name');
        $project->procuring_entity = $request->get('procuring_entity');
        $project->procurement_entity_code = $request->get('procurement_entity_code');
        $project->procuring_entity_district = $request->get('procuring_entity_district');
        $project->procurement_method = $request->get('procurement_method');
        $project->eoi_selection = $request->get('eoi_selection');
        $project->eoi_reference = $request->get('eoi_reference');
        $project->development_partners = $request->get('development_partners');
        $project->programme_code = $request->get('programme_code');
        $project->programme_name = $request->get('programme_name');
        $project->project_director = $request->get('project_director');
        $project->project_lead = $request->get('project_lead');
        $project->client_id = $request->get('client_id');
        $project->project_status = $request->get('project_status');
        $project->project_source = $request->get('project_source');
        $project->contact_person = $request->get('contact_person');
        $project->designation = $request->get('designation');
        $project->contact_person_phone = $request->get('contact_person_phone');
        $project->contact_person_email = $request->get('contact_person_email');
        $project->contact_person_address = $request->get('contact_person_address');
        $project->funded_by = $request->get('funded_by');
        $project->execution_authority = $request->get('execution_authority');
        $project->study_time = $request->get('study_time');
        $project->description = $request->get('description');
        $project->description_2 = $request->get('description_2');
        $project->association = $request->get('association');
        $project->created_by = Auth::user()->id;
        $project->save();

//        //CREATE PROJECT DIRECTOR IN PROJECT_EMPLOYEE
//        if ($project->project_director != NULL){
//            $director = User::find($project->project_director);
//
//            $employee = new ErpProjectEmployee();
//            $employee->project_id = $project->id;
//            $employee->user_id = $director->id;
//            $employee->employee_id = $director->employee_id;
//            $employee->title = "Project Director";
//            $employee->created_by = Auth::user()->id;
//            $employee->save();
//        }
//
//        //CREATE PROJECT SUPERVISOR IN PROJECT_EMPLOYEE
//        if ($project->project_lead != NULL) {
//            $lead = User::find($project->project_lead);
//
//            $employee = new ErpProjectEmployee();
//            $employee->project_id = $project->id;
//            $employee->user_id = $lead->id;
//            $employee->employee_id = $lead->employee_id;
//            $employee->title = "Project Supervisor";
//            $employee->created_by = Auth::user()->id;
//            $employee->save();
//        }

        // CREATE PROJECT DETAILS
        $new_project = ErpProject::latest()->first();

        $phase = new ErpProjectPhaseDetail;
        $phase->project_id = $new_project->id;
        $phase->project_phase = $request->get('project_phase');
        $phase->phase_status = $request->get('project_status');
        if( $request->get('eoi_publication_date') != ''){
            $phase->phase_start_date = date('Y-m-d', strtotime($request->get('eoi_publication_date')));
        }
        if( $request->get('eoi_due_date') != ''){
            $phase->phase_end_date = date('Y-m-d', strtotime($request->get('eoi_due_date')));
        }
        if( $request->get('eoi_due_time') != ''){
            $phase->phase_end_time = date('H:i', strtotime($request->eoi_due_time));
        }
        $phase->meeting_place = $request->get('meeting_place');
        $phase->created_by = Auth::user()->id;
        $phase->save();

//      CREATE PROJECT INCOME ACCOUNTS
        $income = ErpChartOfAccounts::select('coa_reference_no')->where('coa_reference_no','LIKE',"150505%")->latest()->first();
        if($income){
            $coa_income_last=$income->coa_reference_no+1;
        }else{
            $coa_income_last= 15050501;
        }
        $coa_income = new ErpChartOfAccounts();
        $coa_income->coa_reference_no = $coa_income_last;
        $coa_income->coa_header_id = 150505;
        $coa_income->coa_name = $request->project_name.' Income';
        $coa_income->project_id = $new_project->id;
        $coa_income->account_type = 'credit';
        $coa_income->save();

//      CREATE PROJECT EXPENSE ACCOUNTS
        $expense = ErpChartOfAccounts::select('coa_reference_no')->where('coa_reference_no','LIKE',"150603%")->latest()->first();
        if($expense){
            $coa_expense_last=$expense->coa_reference_no+1;
        }else{
            $coa_expense_last= 15060301;
        }
        $coa_expense = new ErpChartOfAccounts();
        $coa_expense->coa_reference_no = $coa_expense_last;
        $coa_expense->coa_header_id = 150603;
        $coa_expense->coa_name = $request->project_name. ' Expenses';
        $coa_expense->project_id = $new_project->id;
        $coa_expense->account_type = 'debit';
        $coa_expense->child = 1;
        $coa_expense->save();

        //Create Miscellaneous Expense Account
        $coa_expense_mis = new ErpChartOfAccounts();
        $coa_expense_mis->coa_reference_no = ($coa_expense_last - 15000000) * 100 + 1;
        $coa_expense_mis->coa_parent = $coa_expense->coa_reference_no;
        $coa_expense_mis->coa_name = $request->project_name. ' Miscellaneous Expenses';
        $coa_expense_mis->project_id = $new_project->id;
        $coa_expense_mis->account_type = 'debit';
        $coa_expense_mis->save();

        return redirect('/project')->with('message-success', 'Project has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $editData = ErpProject::find($id);
        $clients = ErpClient::where('active_status', '=', '1')->get();
        $employees= ErpEmployee::where('active_status', '=', '1')->get();
        $all_projects = ErpProject::where('active_status', 1)->get();
        $salaries = ErpEmployeeSalary::select('employee_id', 'hourly_rate')->whereRaw('id IN (select MAX(id) FROM erp_employee_salaries GROUP BY employee_id)')->get();
        // $salary = ErpEmployeeSalary::select('employee_id', 'hourly_rate')->orderBy('employee_id', 'desc')->first();

        $phases = ErpProjectPhase::all();
        $phase_detail = ErpProjectPhaseDetail::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->latest()->first();
        $distinct_phases = ErpProjectPayment::where('project_id', '=', $id)->distinct('project_phase')->orderBy('project_phase', 'desc')->get(['project_phase']);

//        $setup = ErpSetup::latest()->first();
        
        $products = ErpProduct::where('product_type', '=', 0)->get();
        $assets = ErpProduct::where('product_type', '=', 1)->get();
        $distinct_material_phase = ErpProjectMaterial::where('project_id', '=', $id)->distinct('project_phase')->orderBy('project_phase', 'desc')->get(['project_phase']);

        $project_employees = ErpProjectEmployee::where('project_id', '=', $id)->get();
        //$distinct_employee_phase = ErpProjectEmployee::where('project_id', '=', $id)->distinct('project_phase')->orderBy('project_phase', 'desc')->get(['project_phase']);
        $distinct_employee_phase = ErpProjectEmployee::where('project_id', '=', $id)->select('project_phase', 'amendment')->orderBy('project_phase', 'desc')->orderBy('amendment', 'desc')->groupBy('project_phase', 'amendment')->get();
        $distinct_advance_phase = ErpProjectAdvances::where('project_id', '=', $id)->select('project_phase', 'amendment')->orderBy('project_phase', 'desc')->orderBy('amendment', 'desc')->groupBy('project_phase', 'amendment')->get();
        $distinct_progress_phase = ErpProjectProgressPayment::where('project_id', '=', $id)->select('project_phase', 'amendment')->orderBy('project_phase', 'desc')->orderBy('amendment', 'desc')->groupBy('project_phase', 'amendment')->get();


//        $project_employees = ErpProjectEmployee::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();


        $tasks = ErpTask::where('project_id', '=', $id)->where('active_status', '=', 1)->orderBy('task_id')->get();
        $todos = ErpProjectTodo::where('project_id', '=', $id)->where('active_status', '=', 1)->where('created_by', '=', Auth::user()->id)->orderBy('due_date')->get();

        $budgets = ErpProjectBudget::where('project_id', '=', $id)->get();
        $progress = ErpProjectProgressPayment::where('project_id', '=', $id)->get();

//        $budgets = ErpProjectBudget::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $distinct_budget_phase = ErpProjectBudget::where('project_id', '=', $id)->select('project_phase', 'amendment')->orderBy('project_phase', 'desc')->orderBy('amendment', 'desc')->groupBy('project_phase', 'amendment')->get();

        $documents = ErpProjectDocument::where('project_id', '=', $id)->orderBy('created_at', 'DESC')->get();
        $users = User::all();

        $reporting = ErpProjectReporting::where('project_id', '=', $id)->get();


        $maxAmendmentReporting = 0;
        foreach ($reporting as $report) {

            if ($report->amendment > $maxAmendmentReporting) {
                $maxAmendmentReporting = $report->amendment;
            }
        }
        //Remuneration Expenses

        $project_employees0 = ErpProjectEmployee::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $project_employees1 = ErpProjectEmployee::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->where('amendment', '=', 1)->get();

        if ($project_employees1->isEmpty()) {
            $editData = ErpProject::find($id);
            $project_employeesxy = ErpProjectEmployee::where('project_id', '=', $editData->id)->where('project_phase', '=', $editData->project_phase)->get();

            foreach ($project_employeesxy as $project_employee) {

                if ($project_employee->is_amendment == 1) {
                    $project_employee->is_amendment = 0;
                    $project_employee->save();
                }
            }
        }
        $maxAmendment = -1;
        foreach ($project_employees0 as $project_employee) {

            if ($project_employee->amendment > $maxAmendment) {
                $maxAmendment = $project_employee->amendment;
            }
        }
//reimbursable expenses
        $budgets0 = ErpProjectBudget::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $budgets1 = ErpProjectBudget::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->where('amendment', '=', 1)->get();

        if ($budgets1->isEmpty()) {
            $editData = ErpProject::find($id);
            $project_budgetxy = ErpProjectBudget::where('project_id', '=', $editData->id)->where('project_phase', '=', $editData->project_phase)->get();

            foreach ($project_budgetxy as $project_budget) {

                if ($project_budget->is_amendment == 1) {
                    $project_budget->is_amendment = 0;
                    $project_budget->save();
                }
            }
        }

        $maxAmendmentBudget = -1;
        foreach ($budgets0 as $budget) {

            if ($budget->amendment > $maxAmendmentBudget) {
                $maxAmendmentBudget = $budget->amendment;
            }
        }


//Advance payment
        $project_advances0 = ErpProjectAdvances::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $project_advances1 = ErpProjectAdvances::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->where('amendment', '=', 1)->get();

        if ($project_advances1->isEmpty()) {
            $editData = ErpProject::find($id);
            $project_advancesxy = ErpProjectAdvances::where('project_id', '=', $editData->id)->where('project_phase', '=', $editData->project_phase)->get();

            foreach ($project_advancesxy as $project_employee) {

                if ($project_employee->is_amendment == 1) {
                    $project_employee->is_amendment = 0;
                    $project_employee->save();
                }
            }
        }
        $maxAmendmentAdvance = -1;
        foreach ($project_advances0 as $advance) {

            if ($advance->amendment > $maxAmendmentAdvance) {
                $maxAmendmentAdvance = $advance->amendment;
            }

        }

//Progress Payment
        $project_progress0 = ErpProjectProgressPayment::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $project_progress1 = ErpProjectProgressPayment::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->where('amendment', '=', 1)->get();
        if ($project_progress1->isEmpty()) {
            $editData = ErpProject::find($id);

            $project_progressesxy = ErpProjectProgressPayment::where('project_id', '=', $editData->id)->where('project_phase', '=', $editData->project_phase)->get();
            foreach ($project_progressesxy as $project_employee) {

                if ($project_employee->is_amendment == 1) {
                    $project_employee->is_amendment = 0;
                    $project_employee->save();
                }
            }
        }
        $maxAmendmentProgress = -1;
        foreach ($project_progress0 as $progress) {

            if ($progress->amendment > $maxAmendmentProgress) {
                $maxAmendmentProgress = $progress->amendment;
            }

        }


        //project task

        $maxAmendmentTask = -1;
        foreach ($tasks as $task) {

            if ($task->amendment > $maxAmendmentTask) {
                $maxAmendmentTask = $task->amendment;
            }

        }
        $maxAmendmentDeliverable = -1;
        foreach ($editData->deliverable as $deliverable) {

            if ($deliverable->amendment > $maxAmendmentDeliverable) {
                $maxAmendmentDeliverable = $deliverable->amendment;
            }
        }


        return view('backEnd.projects.show', compact(
            'editData',
            'clients',
            'employees',
            'all_projects',
            'salaries',
            'phases',
            'phase_detail',
            'distinct_phases',
            'products',
            'assets',
            'distinct_material_phase',
            'project_employees',
            'distinct_employee_phase',
            'tasks',
            'todos',
            'budgets',
            'distinct_budget_phase',
            'documents',
            'users',
            'progress',
            'maxAmendment',
            'maxAmendmentBudget',
            'maxAmendmentAdvance',
            'maxAmendmentProgress',
            'maxAmendmentTask',
            'maxAmendmentReporting',
            'maxAmendmentDeliverable',
            'distinct_advance_phase',
            'distinct_progress_phase'
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
        $editData = ErpProject::find($id);
        $clients = ErpClient::where('active_status', '=', '1')->get();
        $users = User::where('active_status', '=', '1')->where('id', '!=', '5')->get();
        $project_phase = ErpProjectPhaseDetail::where('project_id', $id)->first();
        $phases = ErpProjectPhase::orderBy('defined_id')->get();
        $next_phase = $editData->project_phase + 1;
        $components = ErpProjectComponent::all();
        $statuses = ErpStatus::all();
        $types = ErpProjectType::all();
        return view('backEnd.projects.edit', compact('editData', 'clients', 'users', 'project_phase', 'phases', 'next_phase', 'components', 'statuses', 'types'));
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
            'project_full_name' => 'required',
            'contact_person'=> 'required|string|min:3|max:100',
            'procuring_entity' => 'min:0|max:250',
            'procuring_entity_district' => 'min:0|max:100',
            'procurement_entity_code' => 'min:0|max:200',
            'eoi_reference' => 'min:0|max:100',
            'eoi_selection' => 'min:0|max:250',
            'procurement_method' => 'min:0|max:250',
            'programme_code' => 'min:0|max:100',
            'programme_name' => 'min:0|max:150',
            'designation' => 'min:0|max:100',
            'contact_person_phone' => 'min:0|max:100',
            'contact_person_email' => 'min:0|max:100',
            'execution_authority' => 'min:0|max:250',
            'project_source' => 'min:0|max:150',
        ]);

        $project = ErpProject::find($id);
        $project->project_code = $request->get('project_code');
        $project->project_full_name = $request->get('project_full_name');
        if( $request->project_type != null ){
            $type = implode(",", $request->get('project_type'));
            $project->project_type = $type;
        }
        $project->contract_type = $request->get('contract_type');
        if ($project->contract_type == 1) {
            $project->epc_share_percentage = $request->get('epc_share_percentage');
            $project->epc_lead = $request->get('epc_lead');
        }
        $project->project_component = $request->get('project_component');
        $project->project_source = $request->get('project_source');
        $project->project_status = $request->get('project_status');
        $project->epc_share_percentage = $request->get('epc_share_percentage');
        $project->epc_lead = $request->get('epc_lead');
        $project->procuring_entity = $request->get('procuring_entity');
        $project->procurement_entity_code = $request->get('procurement_entity_code');
        $project->procuring_entity_district = $request->get('procuring_entity_district');
        $project->procurement_method = $request->get('procurement_method');
        if( $request->get('eoi_date') != ''){
            $project->eoi_submission_date = date('Y-m-d', strtotime($request->get('eoi_date')));
        }
        $project->eoi_selection = $request->get('eoi_selection');
        $project->eoi_reference = $request->get('eoi_reference');
        $project->development_partners = $request->get('development_partners');
        $project->programme_code = $request->get('programme_code');
        $project->programme_name = $request->get('programme_name');
        $project->project_director = $request->get('project_director');
        $project->project_lead = $request->get('project_lead');
        $project->client_id = $request->get('client_id');
        $project->project_source = $request->get('project_source');
        $project->client_id = $request->get('client_id');
        $project->contact_person = $request->get('contact_person');
        $project->designation = $request->get('designation');
        $project->contact_person_phone = $request->get('contact_person_phone');
        $project->contact_person_email = $request->get('contact_person_email');
        $project->contact_person_address = $request->get('contact_person_address');
        $project->funded_by = $request->get('funded_by');
        $project->execution_authority = $request->get('execution_authority');
        $project->study_time = $request->get('study_time');
        $project->description = $request->get('description');
        $project->description_2 = $request->get('description_2');
        $project->association = $request->get('association');
        if( $request->get('project_due_date') != ''){
            $project->project_due_date = date('Y-m-d', strtotime($request->get('project_due_date')));
        }
        if( $request->get('extended_date') != ''){
            $project->new_deadline = date('Y-m-d', strtotime($request->extended_date));
        }
        $project->project_amount = $request->get('project_amount');
        if ( $request->project_status == 'completed' && $project->extended_date != null) {
            $project->completed_on = date('Y-m-d', strtotime($project->extended_date));
        }
        else if ($request->project_status == 'completed')
            $project->completed_on = date('Y-m-d', strtotime($request->project_due_date));
        $project->updated_by = Auth::user()->id;
        $project->update();

        $phase = ErpProjectPhaseDetail::where('project_id', $id)->first();
        $phase->phase_status = $request->get('project_status');
        if( $request->get('eoi_publication_date') != ''){
            $phase->phase_start_date = date('Y-m-d', strtotime($request->get('eoi_publication_date')));
        }
        if( $request->get('eoi_due_date') != ''){
            $phase->phase_end_date = date('Y-m-d', strtotime($request->get('eoi_due_date')));
        }
        if( $request->get('eoi_due_time') != ''){
            $phase->phase_end_time = date('H:i', strtotime($request->eoi_due_time));
        }
        $phase->meeting_place = $request->get('meeting_place');
        $phase->updated_by = Auth::user()->id;
        $phase->update();

//        //CREATE PROJECT DIRECTOR IN PROJECT_EMPLOYEE
//        if ($project->project_director != NULL){
//            $director = ErpProjectEmployee::where('project_id', '=', $id)->where('title', '=', 'Project Director')->latest()->first();
//            if ($director){
//                $project_director = User::find($project->project_director);
//                $director->user_id = $project_director->id;
//                $director->employee_id = $project_director->employee_id;
//                $director->updated_by = Auth::user()->id;
//                $director->update();
//            }
//            else {
//                $project_director = User::find($project->project_director);
//                $employee = new ErpProjectEmployee();
//                $employee->project_id = $project->id;
//                $employee->user_id = $project_director->id;
//                $employee->employee_id = $project_director->employee_id;
//                $employee->title = "Project Director";
//                $employee->created_by = Auth::user()->id;
//                $employee->save();
//            }
//        }
//        //CREATE PROJECT SUPERVISOR IN PROJECT_EMPLOYEE
//        if ($project->project_lead != NULL) {
//            $project_lead = ErpProjectEmployee::where('project_id', '=', $id)->where('title', '=', 'Project Supervisor')->latest()->first();
//            if ($project_director){
//                $lead = User::find($project->project_lead);
//                $project_lead->user_id = $lead->id;
//                $project_lead->employee_id = $lead->employee_id;
//                $project_lead->updated_by = Auth::user()->id;
//                $project_lead->update();
//            }
//            else {
//                $lead = User::find($project->project_lead);
//                $employee = new ErpProjectEmployee();
//                $employee->project_id = $project->id;
//                $employee->user_id = $lead->id;
//                $employee->employee_id = $lead->employee_id;
//                $employee->title = "Project Supervisor";
//                $employee->created_by = Auth::user()->id;
//                $employee->save();
//            }
//        }
        return redirect('/project')->with('message-success', 'Project has been updated');
    }

    public function nextPhase($id)
    {
        $start = false;
        $editData = ErpProject::find($id);
        $phases = ErpProjectPhase::where('required', '=', 1)->orderBy('defined_id')->get();
        $next_phase = $editData->project_phase + 1;
        if($next_phase == 3){
            $start = true;
        }
        $statuses = ErpStatus::where('phases', 0)->orWhere('phases', '<', $next_phase)->get();
         return view('backEnd.projects.nextPhase', compact('editData', 'phases', 'next_phase', 'start', 'statuses'));
    }

    public function updatePhase(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'project_phase' =>'required',
            'proposal_validity' =>'min:0|max:150',
            'assign_name_1' =>'min:0|max:150',
            'assign_name_2' =>'min:0|max:150',
            'assign_name_3' =>'min:0|max:150',
        ]);
        $project = ErpProject::find($id);

        $phase = ErpProjectPhaseDetail::where('project_id', $id)->where('project_phase', '=', $request->project_phase)->latest()->first();

        if($phase) {
            $phase->phase_status = $request->get('status');
            if ($request->get('phase_start_date') != '') {
                $phase->phase_start_date = date('Y-m-d', strtotime($request->get('phase_start_date')));
            }
            if ($request->get('phase_end_date') != '') {
                $phase->phase_end_date = date('Y-m-d', strtotime($request->get('phase_end_date')));
            }
            $phase->phase_end_time = date('H:i', strtotime($request->phase_end_time));
            $phase->proposal_meeting_place = $request->proposal_meeting_place;
            if ($request->get('meeting_date') != '') {
                $phase->meeting_date = date('Y-m-d', strtotime($request->get('meeting_date')));
            }
            $phase->meeting_time = date('H:i', strtotime($request->meeting_time));
            $phase->proposal_validity = $request->get('proposal_validity');
            $phase->assign_name_1 = $request->get('assign_name_1');
            $phase->assign_desc_1 = $request->get('assign_desc_1');
            $phase->assign_name_2 = $request->get('assign_name_2');
            $phase->assign_desc_2 = $request->get('assign_desc_2');
            $phase->assign_name_3 = $request->get('assign_name_3');
            $phase->assign_desc_3 = $request->get('assign_desc_3');
            $phase->remark = $request->get('remark');
            $phase->created_by = Auth::user()->id;
            $phase->update();
        }
        else{
            $phase = new ErpProjectPhaseDetail;
            $phase->project_id = $id;
            $phase->project_phase = $request->get('project_phase');
            $phase->phase_status = $request->get('status');
            if ($request->get('phase_start_date') != '') {
                $phase->phase_start_date = date('Y-m-d', strtotime($request->get('phase_start_date')));
            }
            if ($request->get('phase_end_date') != '') {
                $phase->phase_end_date = date('Y-m-d', strtotime($request->get('phase_end_date')));
            }
            $phase->phase_end_time = date('H:i', strtotime($request->phase_end_time));
            $phase->proposal_meeting_place = $request->proposal_meeting_place;
            if ($request->get('meeting_date') != '') {
                $phase->meeting_date = date('Y-m-d', strtotime($request->get('meeting_date')));
            }
            $phase->meeting_time = date('H:i', strtotime($request->meeting_time));
            $phase->proposal_validity = $request->get('proposal_validity');
            $phase->assign_name_1 = $request->get('assign_name_1');
            $phase->assign_desc_1 = $request->get('assign_desc_1');
            $phase->assign_name_2 = $request->get('assign_name_2');
            $phase->assign_desc_2 = $request->get('assign_desc_2');
            $phase->assign_name_3 = $request->get('assign_name_3');
            $phase->assign_desc_3 = $request->get('assign_desc_3');
            $phase->remark = $request->get('remark');
            $phase->created_by = Auth::user()->id;
            $phase->save();
        }

        if ($request->rfp_no){
            $project->rfp_no = $request->get('rfp_no');
        }
        if ($request->selection_method){
            $project->selection_method = $request->get('selection_method');
        }
        $project->project_phase = $request->get('project_phase');
        $project->project_status = $request->get('status');

        if($request->project_phase == 3 ){
            if ($request->project_start_date != '') {
                $project->project_start_date = date('Y-m-d', strtotime($request->get('project_start_date')));
            }
            if ($request->project_end_date != '') {
                $project->project_due_date = date('Y-m-d', strtotime($request->get('project_end_date')));
            }
            $project->project_amount = $request->get('project_amount');
            $project->tax_amount = $request->get('tax_amount');
            $project->amount_after_tax = $request->get('amount_after_tax');
            $project->tax_by = $request->get('tax_by');

            if ($phase->phase_start_date == null && $project->project_start_date != null) {
                $phase->phase_start_date = date('Y-m-d', strtotime($request->get('project_start_date')));
                $phase->update();
            }
        }
        $project->update();

        return redirect('/project/'.$id)->with('message-success', 'Project has been updated');
    }

    public function createJointVenture($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        return view('backEnd.projects.createJV', compact('project'));
    }

    public function storeJointVenture(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'jv_name' =>'required|string|min:1|max:200',
            'jv_leading' =>'required',
            'share_percentage' =>'required',
            'contact_person'=>'required|string|min:1|max:100',
            'designation'=>'min:0|max:100',
            'email'=>'min:0|max:100',
            'phone_number'=>'min:0|max:100',
        ]);

        $project_id = $id;

        $venture = new ErpProjectJointVenture();
        $venture->project_id = $project_id;
        $venture->jv_name = $request->get('jv_name');
        $venture->jv_leading = $request->get('jv_leading');
        $venture->share_percentage = $request->get('share_percentage');
        $venture->contact_person = $request->get('contact_person');
        $venture->designation = $request->get('designation');
        $venture->email = $request->get('email');
        $venture->phone_number = $request->get('phone_number');
        $venture->address = $request->get('address');
        $venture->remarks = $request->get('remarks');
        $venture->created_by = Auth::user()->id;
        $result = $venture->save();

        $project = ErpProject::find($project_id);
        $project->jv_party++;
        $project->update();

        if($result) {
        return redirect( '/project/'.$project_id )->with('message-success', 'A Joint Venture has been added');
        } else {
            return redirect('/project/'.$project_id)->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function editJointVenture($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpProjectJointVenture::find($id);
        // dd($editData);
        return view('backEnd.projects.createJV', compact('editData'));
    }

    public function updateJointVenture(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'jv_name' =>'required|string|min:1|max:200',
            'jv_leading' =>'required',
            'share_percentage' =>'required',
            'contact_person'=>'required|string|min:1|max:100',
            'designation'=>'min:0|max:100',
            'email'=>'min:0|max:100',
            'phone_number'=>'min:0|max:100',
        ]);
        $venture = ErpProjectJointVenture::find($id);
        $venture->jv_name = $request->get('jv_name');
        $venture->jv_leading = $request->get('jv_leading');
        $venture->share_percentage = $request->get('share_percentage');
        $venture->contact_person = $request->get('contact_person');
        $venture->designation = $request->get('designation');
        $venture->email = $request->get('email');
        $venture->phone_number = $request->get('phone_number');
        $venture->address = $request->get('address');
        $venture->remarks = $request->get('remarks');
        $venture->updated_by = Auth::user()->id;

        $result = $venture->update();
        if($result) {
        return redirect( '/project/'.$venture->project_id )->with('message-success', 'Joint Venture has been updated');
        } else {
            return redirect('/project/'.$venture->project_id)->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function addProjectEmployee(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'title'=>'min:0|max:100',

        ]);
        $project = ErpProject::find($id);

        $employee = new ErpProjectEmployee();
        $employee->project_id = $id;
        $employee->employee_id = $request->employee;
        $employee->project_phase = $project->project_phase;
        $employee->title = $request->get('title');
        $employee->man_hour = $request->get('man_hour');
        $employee->staff_month_rate = $request->staff_month_rate;
        $employee->staff_month_proposal = $request->staff_month_proposal;
        $employee->staff_month_agreed = $request->staff_month_agreed;
        $employee->created_by = Auth::user()->id;
        if ($request->amendment == null) {
            $employee->amendment = 0;
        } else {

            $employee->amendment = $request->amendment;

            $employee->is_amendment = 1;
            $x = ErpProjectEmployee::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }

        }
        $user = User::where('employee_id', '=', $request->employee)->first();
        if ($user != null) {
            $employee->user_id = $user->id;
        }
        $result = $employee->save();

        //1. Input rest 4 rows of employee
        if ($request->employee_1 != null || $request->title_1 != null || $request->man_hour_1 != null || $request->staff_month_rate_1 != null || $request->staff_month_proposal_1 != null || $request->staff_month_agreed_1 != null) {
            $employee = new ErpProjectEmployee();
            $employee->project_id = $id;
            $employee->employee_id = $request->employee_1;
            $employee->project_phase = $project->project_phase;
            $employee->title = $request->title_1;
            $employee->man_hour = $request->man_hour_1;
            $employee->staff_month_rate = $request->staff_month_rate_1;
            $employee->staff_month_proposal = $request->staff_month_proposal_1;
            $employee->staff_month_agreed = $request->staff_month_agreed_1;
            if ($request->amendment == null) {
                $employee->amendment = 0;
            } else {
                $employee->amendment = $request->amendment;
                $employee->is_amendment = 1;

            }
            $employee->created_by = Auth::user()->id;
            $user = User::where('employee_id', '=', $request->employee)->first();
            if ($user != null) {
                $employee->user_id = $user->id;
            }
            $result1 = $employee->save();
        }
        //2. Input rest 4 rows of employee
        if ($request->employee_2 != null || $request->title_2 != null || $request->man_hour_2 != null || $request->staff_month_rate_2 != null || $request->staff_month_proposal_2 != null || $request->staff_month_agreed_2 != null) {
            $employee = new ErpProjectEmployee();
            $employee->project_id = $id;
            $employee->employee_id = $request->employee_2;
            $employee->project_phase = $project->project_phase;
            $employee->title = $request->title_2;
            $employee->man_hour = $request->man_hour_2;
            $employee->staff_month_rate = $request->staff_month_rate_2;
            $employee->staff_month_proposal = $request->staff_month_proposal_2;
            $employee->staff_month_agreed = $request->staff_month_agreed_2;
            if ($request->amendment == null) {
                $employee->amendment = 0;
            } else {
                $employee->amendment = $request->amendment;
                $employee->is_amendment = 1;

            }
            $employee->created_by = Auth::user()->id;
            $user = User::where('employee_id', '=', $request->employee)->first();
            if ($user != null) {
                $employee->user_id = $user->id;
            }
            $result2 = $employee->save();
        }
        //3. Input rest 4 rows of employee
        if ($request->employee_3 != null || $request->title_3 != null || $request->man_hour_3 != null || $request->staff_month_rate_3 != null || $request->staff_month_proposal_3 != null || $request->staff_month_agreed_3 != null) {
            $employee = new ErpProjectEmployee();
            $employee->project_id = $id;
            $employee->employee_id = $request->employee_3;
            $employee->project_phase = $project->project_phase;
            $employee->title = $request->title_3;
            $employee->man_hour = $request->man_hour_3;
            $employee->staff_month_rate = $request->staff_month_rate_3;
            $employee->staff_month_proposal = $request->staff_month_proposal_3;
            $employee->staff_month_agreed = $request->staff_month_agreed_3;
            if ($request->amendment == null) {
                $employee->amendment = 0;
            } else {
                $employee->amendment = $request->amendment;
                $employee->is_amendment = 1;

            }
            $employee->created_by = Auth::user()->id;
            $user = User::where('employee_id', '=', $request->employee)->first();
            if ($user != null) {
                $employee->user_id = $user->id;
            }
            $result3 = $employee->save();
        }
        //4. Input rest 4 rows of employee
        if ($request->employee_4 != null || $request->title_4 != null || $request->man_hour_4 != null || $request->staff_month_rate_4 != null || $request->staff_month_proposal_4 != null || $request->staff_month_agreed_4 != null) {
            $employee = new ErpProjectEmployee();
            $employee->project_id = $id;
            $employee->employee_id = $request->employee_4;
            $employee->project_phase = $project->project_phase;
            $employee->title = $request->title_4;
            $employee->man_hour = $request->man_hour_4;
            $employee->staff_month_rate = $request->staff_month_rate_4;
            $employee->staff_month_proposal = $request->staff_month_proposal_4;
            $employee->staff_month_agreed = $request->staff_month_agreed_4;
            if ($request->amendment == null) {
                $employee->amendment = 0;
            } else {
                $employee->amendment = $request->amendment;
                $employee->is_amendment = 1;

            }
            $employee->created_by = Auth::user()->id;
            $user = User::where('employee_id', '=', $request->employee)->first();
            if ($user != null) {
                $employee->user_id = $user->id;
            }
            $result4 = $employee->save();
        }
        if (($result || $result1 || $result2 || $result3 || $result4) && $employee->amendment == 0) {
            return redirect()->back()->with('message-success', 'Employee has been added successfully');
        }
        if (($result || $result1 || $result2 || $result3 || $result4) && $employee->amendment != 0) {
            return redirect('/project/' . $project->id)->with('message-success', 'Employee has been added successfully');

        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function editProjectEmployee(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $request->validate([
            'title'=>'min:0|max:100',
        ]);

        $employee = ErpProjectEmployee::find($id);
        $employee->employee_id = $request->employee;
        $employee->title = $request->get('title');
        $employee->man_hour = $request->get('man_hour');
        $employee->staff_month_rate = $request->staff_month_rate;
        $employee->staff_month_proposal = $request->staff_month_proposal;
        $employee->staff_month_agreed = $request->staff_month_agreed;
        $employee->updated_by = Auth::user()->id;
        $employee->is_amendment = 1;

        if ($request->amendment != null) {
            $employee->amendment = $request->amendment;
            $x = ErpProjectEmployee::where('project_phase', '=', $employee->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }
        }
        $result = $employee->update();


        if ($result) {
            return redirect()->back()->with('message-success', 'Employee has been updated successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function reassignProjectEmployee(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'reassigned','path'=>url()->current())
        );
        $request->validate([
//            'quantity' => 'required',
        ]);

        $employee = ErpProjectEmployee::find($id);
        $employee->reassign = $request->reassign;
        $employee->updated_by = Auth::user()->id;

        $result = $employee->update();
        if($result) {
            return redirect()->back()->with('message-success', 'Employee has been updated successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function deleteProjectEmployeeView($id){
        $module = 'deleteProjectEmployee';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    public function deleteProjectBudgetView($id){
        $module = 'deleteProjectBudget';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteProjectEmployee($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $result = ErpProjectEmployee::destroy($id);
        if($result){
            return redirect()->back()->with('message-success-delete', 'Employee has been removed successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function addProjectMaterial(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'product' =>'required',
        ]);
        $project = ErpProject::find($id);
        $product = ErpProduct::find($request->product);

        $material = new ErpProjectMaterial();
        $material->project_id = $id;
        $material->project_phase = $project->project_phase;
        $material->product_id = $product->id;
        $name = $product->product;
//        $material->unit = $product->unit;
        if ($request->quantity)
            $quantity = $material->quantity = $request->get('quantity');
        else
            $quantity = $material->quantity = 1;
        $material->description = $request->get('description');
        $material->created_by = Auth::user()->id;

//        $inventories = ErpInventory::where('product_name', $name)->where('quantity', '>', 0)->where('active_status', '=', 1)->select('id', 'quantity')->get();
//
//        foreach ($inventories as $inventory){
//            if ($inventory->quantity >= $quantity){
//                $inventory->quantity -= $quantity;
//                $quantity = 0;
//                $inventory->update();
//            }
//            else{
//                $quantity -= $inventory->quantity;
//                $inventory->quantity = 0;
//                $inventory->update();
//            }
//            if($quantity == 0)
//                break;
//        }
//
//        if($quantity > 0){
//            $material->quantity_sanctioned = $material->quantity - $quantity;
//            $material->quantity_required = $material->quantity - $material->quantity_sanctioned;
//
//            $users = User::role('Admin')->get();
//            foreach ($users as $user){
//                $user->notify(new InventoryRequired($project, $name, $material->quantity_required));
//            }
//        }
//        else{
//            $material->quantity_sanctioned = $material->quantity;
//        }

        $users = User::role('Admin')->get();
        foreach ($users as $user){
            $user->notify(new InventoryRequired($project, $name, $quantity));
        }

        $result = $material->save();

        if ($request->product_1 != null || $request->description_1 != null ) {
            $product = ErpProduct::find($request->product_1);

            $material = new ErpProjectMaterial();
            $material->project_id = $id;
            $material->project_phase = $project->project_phase;
            $name = $material->product_name = $product->product;
            $material->unit = $product->unit;
            $quantity = $material->quantity = $request->quantity_1;
            $material->quantity_sanctioned = 0;
            $material->description = $request->description_1;
            $material->created_by = Auth::user()->id;
            $material->save();

            $users = User::role('Admin')->get();
            foreach ($users as $user){
                $user->notify(new InventoryRequired($project, $name, $quantity));
            }
        }
        if ($request->product_2 != null || $request->description_2 != null ) {
            $product = ErpProduct::find($request->product_2);

            $material = new ErpProjectMaterial();
            $material->project_id = $id;
            $material->project_phase = $project->project_phase;
            $name = $material->product_name = $product->product;
            $material->unit = $product->unit;
            $quantity = $material->quantity = $request->quantity_2;
            $material->quantity_sanctioned = 0;
            $material->description = $request->description_2;
            $material->created_by = Auth::user()->id;
            $material->save();

            $users = User::role('Admin')->get();
            foreach ($users as $user){
                $user->notify(new InventoryRequired($project, $name, $quantity));
            }}
        if ($request->product_3 != null || $request->description_3 != null ) {
            $product = ErpProduct::find($request->product_3);

            $material = new ErpProjectMaterial();
            $material->project_id = $id;
            $material->project_phase = $project->project_phase;
            $name = $material->product_name = $product->product;
            $material->unit = $product->unit;
            $quantity = $material->quantity = $request->quantity_3;
            $material->quantity_sanctioned = 0;
            $material->description = $request->description_3;
            $material->created_by = Auth::user()->id;
            $material->save();

            $users = User::role('Admin')->get();
            foreach ($users as $user){
                $user->notify(new InventoryRequired($project, $name, $quantity));
            }}
        if ($request->product_4 != null || $request->description_4 != null ) {
            $product = ErpProduct::find($request->product_4);

            $material = new ErpProjectMaterial();
            $material->project_id = $id;
            $material->project_phase = $project->project_phase;
            $name = $material->product_name = $product->product;
            $material->unit = $product->unit;
            $quantity = $material->quantity = $request->quantity_4;
            $material->quantity_sanctioned = 0;
            $material->description = $request->description_4;
            $material->created_by = Auth::user()->id;
            $material->save();

            $users = User::role('Admin')->get();
            foreach ($users as $user){
                $user->notify(new InventoryRequired($project, $name, $quantity));
            }}

        if($result) {
            return redirect('/project/'.$id)->with('message-success', 'Material has been added successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function updateProjectMaterial(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'quantity' =>'required',
        ]);
        $material = ErpProjectMaterial::find($id);

        $project_id = $material->project_id;
        $project = ErpProject::find($project_id);

        $name = $material->product_name;
        $quantity = $request->quantity - $material->quantity;
        $material->quantity = $request->get('quantity');
        $material->description = $request->get('description');
        $material->updated_by = Auth::user()->id;

//        $inventories = ErpInventory::where('product_name', $name)->where('quantity', '>', 0)->where('active_status', '=', 1)->select('id', 'quantity')->get();
//
//        foreach ($inventories as $inventory){
//            if ($inventory->quantity >= $quantity){
//                $inventory->quantity -= $quantity;
//                $quantity = 0;
//                $inventory->update();
//            }
//            else{
//                $quantity -= $inventory->quantity;
//                $inventory->quantity = 0;
//                $inventory->update();
//            }
//            if($quantity == 0)
//                break;
//        }
//
//        if($quantity > 0){
//            $material->quantity_sanctioned = $material->quantity - $quantity;
//            $material->quantity_required = $material->quantity - $material->quantity_sanctioned;
//
            $users = User::role('Admin')->get();
            foreach ($users as $user){
                $user->notify(new InventoryRequired($project, $name, $quantity));
            }
//
//        }
//        else{
//            $material->quantity_sanctioned = $material->quantity;
//        }

        $result = $material->update();

        if($result) {
            return redirect('/project/'.$project_id)->with('message-success', 'Material has been updated successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function reassignProjectMaterial(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'reassigned','path'=>url()->current())
        );
        $request->validate([
//            'quantity' => 'required',
        ]);

        $material = ErpProjectMaterial::find($id);
        $product = ErpInventory::where('id', $material->inventory_id)->first();

        if ($request->quantity > $material->quantity_sanctioned){
            return redirect('/project/'.$material->project_id)->with('message-danger', 'You cannot assign more that available quantity.');
        }
        else{
            if($request->reassign == 0 && $product){
                $product->quantity += $request->quantity;
                $product->updated_by =  Auth::user()->id;
                $product->update();
            }
            if ($request->reassign >1){                             //resign 0=inventory, 1=back to client, rest project id are greater than 1
                $project = ErpProject::find($request->reassign);

                $mat = new ErpProjectMaterial();
                $mat->project_id = $request->reassign;
                $mat->project_phase = $project->project_phase;
                $mat->product_name = $material->product_name;
                $mat->coa_id = $material->coa_id;
                $mat->unit = $product->unit;
                $mat->quantity_sanctioned = $request->quantity;
                $mat->description = $material->description;
                $mat->created_by = Auth::user()->id;
                $mat->save();
            }

            $material->reassign = $request->reassign;
            $material->updated_by =  Auth::user()->id;
            $material->update();

            return redirect('/project/'.$material->project_id)->with('message-success', 'Product has been reassigned successfully.');
        }
    }

    public function deleteProjectMaterialView($id){
        $module = 'deleteProjectMaterial';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteProjectMaterial($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $material = ErpProjectMaterial::find($id);
        $results = $material->delete();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Product has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function addProjectBudget(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $request->validate([
            'expense_name' => 'required|string|max:200',
            'unit_cost' => 'required|string|min:1|max:100',
            'quantity' => 'required',
        ]);


        $project = ErpProject::find($id);

        $budget = new ErpProjectBudget();
        $budget->project_id = $id;
        $budget->project_phase = $project->project_phase;
        $budget->expense_name = $request->expense_name;
        $budget->unit = $request->unit;
        $budget->unit_cost = $request->unit_cost;
        $budget->quantity = $request->quantity;
        $budget->total_amount = $request->unit_cost * $request->quantity;
        $budget->created_by = Auth::user()->id;
        if ($request->amendment == null) {
            $budget->amendment = 0;
        } else {
            $budget->amendment = $request->amendment;
            $budget->is_amendment = 1;
            $x = ErpProjectBudget::where('project_phase', '=', $project->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }

        }
        $result = $budget->save();

        if ($request->expense_name_1 != null || $request->unit_1 != null || $request->unit_cost_1 != null || $request->quantity_1 != null) {
            $budget = new ErpProjectBudget();
            $budget->project_id = $id;
            $budget->project_phase = $project->project_phase;
            $budget->expense_name = $request->expense_name_1;
            $budget->unit = $request->unit_1;
            $budget->unit_cost = $request->unit_cost_1;
            $budget->quantity = $request->quantity_1;
            $budget->total_amount = $request->unit_cost_1 * $request->quantity_1;
            $budget->created_by = Auth::user()->id;
            if ($request->amendment == null) {
                $budget->amendment = 0;
            } else {
                $budget->amendment = $request->amendment;
                $budget->is_amendment = 1;

            }
            $result1 = $budget->save();
        }
        if ($request->expense_name_2 != null || $request->unit_2 != null || $request->unit_cost_2 != null || $request->quantity_2 != null ) {
            $budget = new ErpProjectBudget();
            $budget->project_id = $id;
            $budget->project_phase = $project->project_phase;
            $budget->expense_name = $request->expense_name_2;
            $budget->unit = $request->unit_2;
            $budget->unit_cost = $request->unit_cost_2;
            $budget->quantity = $request->quantity_2;
            $budget->total_amount = $request->unit_cost_2 * $request->quantity_2;
            $budget->created_by = Auth::user()->id;
            if ($request->amendment == null) {
                $budget->amendment = 0;
            } else {
                $budget->amendment = $request->amendment;
                $budget->is_amendment = 1;

            }
            $result2 = $budget->save();
        }
        if ($request->expense_name_3 != null || $request->unit_3 != null || $request->unit_cost_3 != null || $request->quantity_3 != null ) {
            $budget = new ErpProjectBudget();
            $budget->project_id = $id;
            $budget->project_phase = $project->project_phase;
            $budget->expense_name = $request->expense_name_3;
            $budget->unit = $request->unit_3;
            $budget->unit_cost = $request->unit_cost_3;
            $budget->quantity = $request->quantity_3;
            $budget->total_amount = $request->unit_cost_3 * $request->quantity_3;
            $budget->created_by = Auth::user()->id;
            if ($request->amendment == null) {
                $budget->amendment = 0;
            } else {
                $budget->amendment = $request->amendment;
                $budget->is_amendment = 1;

            }
            $result3 = $budget->save();
        }
        if ($request->expense_name_4 != null || $request->unit_4 != null || $request->unit_cost_4 != null || $request->quantity_4 != null ) {
            $budget = new ErpProjectBudget();
            $budget->project_id = $id;
            $budget->project_phase = $project->project_phase;
            $budget->expense_name = $request->expense_name_4;
            $budget->unit = $request->unit_4;
            $budget->unit_cost = $request->unit_cost_4;
            $budget->quantity = $request->quantity_4;
            $budget->total_amount = $request->unit_cost_4 * $request->quantity_4;
            $budget->created_by = Auth::user()->id;
            if ($request->amendment == null) {
                $budget->amendment = 0;
            } else {
                $budget->amendment = $request->amendment;
                $budget->is_amendment = 1;

            }
            $result4 = $budget->save();
        }

        if (($result || $result1 || $result2 || $result3 || $result4) && $budget->amendment == 0) {
            return redirect()->back()->with('message-success', 'Expense has been added successfully');
        }
        if (($result || $result1 || $result2 || $result3 || $result4) && $budget->amendment != 0) {
            return redirect('/project/' . $project->id)->with('message-success', 'Expense has been added successfully');

        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function updateProjectBudget(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'expense_name' =>'required|string|min:3|max:200',
            'unit_cost' =>'required|string|min:1|max:100',
            'quantity' =>'required',
        ]);
        $project = ErpProject::find($id);

        $budget = ErpProjectBudget::find($id);
//        $budget->project_phase = $project->project_phase;
        $budget->expense_name = $request->expense_name;
        $budget->unit = $request->unit;
        $budget->unit_cost = $request->unit_cost;
        $budget->quantity = $request->quantity;
        $budget->total_amount = $request->unit_cost * $request->quantity;
        $budget->created_by = Auth::user()->id;
        if ($request->amendment != null) {
            $budget->amendment = $request->amendment;
            $budget->is_amendment = 1;
            $x = ErpProjectBudget::where('project_phase', '=', $budget->project_phase)->get();

            foreach ($x as $y) {

                $y->is_amendment = 1;

                $y->save();
            }
        }
        $result = $budget->update();

        if ($result) {
            return redirect()->back()->with('message-success', 'Expense has been updated successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }
    public function deleteProjectBudget(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $budget = ErpProjectBudget::destroy($id);

        if($budget){
            return redirect()->back()->with('message-success-delete', 'Expense has been removed successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }


    }

    public function projectLesson(Request $request, $id)
    {
        $request->validate([
            'lesson' =>'required',
        ]);
        $lesson = new ErpProjectLesson();
        $lesson->project_id = $id;
        $lesson->lesson = $request->lesson;
        $lesson->created_by = Auth::user()->id;
        $result = $lesson->save();

        if ($result){
            return redirect()->back()->with('message-success', 'Lesson has been added successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function projectSignOff(Request $request, $id)
    {
        $request->validate([
            'remark' =>'required',
        ]);
        $sign = new ErpProjectSignoff();
        $sign->project_id = $id;
        $sign->remark = $request->remark;
        $sign->remark_date = date('Y-m-d', strtotime($request->remark_date));
        $sign->remark_time = date('H:i', strtotime($request->remark_time));
        $sign->created_by = Auth::user()->id;
        $result = $sign->save();

        if ($result){
            return redirect()->back()->with('message-success', 'Lesson has been added successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function projectCheckList(Request $request, $id)
    {
        $request->validate([
//            'remark' =>'required',
            'other_name'=>'min:0|max:100',
        ]);
        $checklist = ErpProjectChecklist::where('project_id', $id)->latest()->first();
        if ($checklist){
            $checklist->certificate = $request->certificate;
            $checklist->payment = $request->payment;
            $checklist->report = $request->report;
            $checklist->other = $request->other;
            $checklist->other_name = $request->other_name;
            $checklist->remark = $request->remark;
            $checklist->updated_by = Auth::user()->id;
            $checklist->update();
        }
        else{
            $checklist = new ErpProjectChecklist();
            $checklist->project_id = $id;
            $checklist->certificate = $request->certificate;
            $checklist->payment = $request->payment;
            $checklist->report = $request->report;
            $checklist->other = $request->other;
            $checklist->other_name = $request->other_name;
            $checklist->remark = $request->remark;
            $checklist->created_by = Auth::user()->id;
            $checklist->save();
        }
        return redirect()->back()->with('message-success', 'Check List has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteProjectView($id){
         return view('backEnd.projects.deleteProjectView', compact('id'));
    }

    public function deleteProject($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $project->active_status = 0;

        $coa = ErpChartOfAccounts::where('project_id', $id)->get();
        foreach ($coa as $coa){
            $coa->active_status = 0;
            $coa->update();
        }
        $results = $project->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Project has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function printTask($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $project = ErpProject::find($id);
//        $setup = ErpSetup::latest()->first();

        $tasks = ErpTask::where('project_id', '=', $id)->where('active_status', '=', 1)->orderBy('created_at', 'DESC')->get();
        $todos = ErpProjectTodo::where('project_id', '=', $id)->where('active_status', '=', 1)->where('created_by', '=', Auth::user()->id)->orderBy('due_date')->get();
        return view('backEnd.projects.printTask', compact(
            'project',
            'tasks',
            'todos'
        ));
    }

    //amnedment
    public function createRemunerationAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $editData = ErpProject::find($id);
        $project_employees = ErpProjectEmployee::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();

        $maxAmendment = 0;
        foreach ($project_employees as $project_employee) {

            if ($project_employee->amendment > $maxAmendment) {
                $maxAmendment = $project_employee->amendment;
            }
        }

        $employees = ErpEmployee::where('active_status', '=', '1')->get();

        return view('backEnd.amendment.remuneration', compact('editData', 'employees', 'maxAmendment'));
    }

    public function createReimbursableAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $editData = ErpProject::find($id);
        $budgets = ErpProjectBudget::where('project_id', '=', $id)->where('project_phase', '=', $editData->project_phase)->get();
        $maxAmendment = 0;
        foreach ($budgets as $budget) {
            if ($budget->amendment > $maxAmendment) {
                $maxAmendment = $budget->amendment;
            }
        }


        return view('backEnd.amendment.reimbursable', compact('editData', 'maxAmendment'));
    }

    public function createAdvanceAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $advances = ErpProjectAdvances::where('project_id', '=', $id)->where('project_phase', '=', $project->project_phase)->get();
        $maxAmendmentAdvance = 0;
        foreach ($advances as $advance) {

            if ($advance->amendment > $maxAmendmentAdvance) {
                $maxAmendmentAdvance = $advance->amendment;
            }
        }

        return view('backEnd.amendment.advance', compact('project', 'maxAmendmentAdvance'));
    }

    public function createProgressAmendment($id)
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


        return view('backEnd.amendment.progress', compact('project', 'maxAmendmentProgress'));
    }

    public function createTaskAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $tasks = ErpTask::where('project_id', '=', $id)->where('active_status', '=', 1)->orderBy('task_id')->get();
        $parents = ErpTask::select('id', 'task_id')->get();
        $maxAmendment = 0;
        foreach ($tasks as $task) {

            if ($task->amendment > $maxAmendment) {
                $maxAmendment = $task->amendment;
            }
        }
        return view('backEnd.amendment.task', compact('project', 'parents', 'maxAmendment'));
    }

    public function createReportingAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $reporting = ErpProjectReporting::where('project_id', '=', $id)->get();
        $maxAmendmentReporting = 0;
        foreach ($reporting as $report) {

            if ($report->amendment > $maxAmendmentReporting) {
                $maxAmendmentReporting = $report->amendment;
            }
        }
        return view('backEnd.amendment.reporting', compact('project', 'maxAmendmentReporting'));
    }

    public function createDeliverableAmendment($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        $reports = ErpProjectReporting::where('project_id', $id)->get();
        $deliverables = ErpProjectDeliverable::where('project_id', $id)->get();
        $maxAmendmentDeliverable = 0;
        foreach ($deliverables as $deliverable) {

            if ($deliverable->amendment > $maxAmendmentDeliverable) {
                $maxAmendmentDeliverable = $deliverable->amendment;
            }
        }
        return view('backEnd.amendment.deliverable', compact('project', 'reports', 'maxAmendmentDeliverable'));
    }
}

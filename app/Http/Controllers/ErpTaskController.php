<?php

namespace App\Http\Controllers;

use App\ErpProject;
use App\ErpProjectEmployee;
use App\ErpProjectPhase;
use App\ErpProjectTodo;
use App\ErpTask;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskChecked;
use App\Notifications\TaskSubmitted;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Notification;

class ErpTaskController extends Controller
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
        $tasks = ErpTask::where('project_id', '=', $id)->get();
        $maxAmendment = 0;
        foreach ($tasks as $task) {

            if ($task->amendment > $maxAmendment) {
                $maxAmendment = $task->amendment;
            }
        }
        $project = ErpProject::find($id);
        $parents = ErpTask::select('id', 'task_id')->get();
        return view('backEnd.tasks.create', compact('project', 'parents','maxAmendment'));
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
            'task_id' => 'required|string|min:1|max:20',
            'task_name' =>'required|string|min:3|max:200',
        ]);

        $project_id = $request->project_id;
        $project = ErpProject::find($project_id);
        $parent = ErpTask::find($request->parent_id);

        $task = new ErpTask();
        $task->project_id = $project_id;
        $task->project_phase = $project->project_phase;
        $task->task_id = $request->get('task_id');
        $task->task_name = $request->get('task_name');
        $task->priority = $request->get('priority');
        $task->task_status = $request->get('task_status');
        $task->employee_id = $request->get('employee_id');
        if ($request->due_date != null) {
            $task->due_date = date('Y-m-d', strtotime($request->due_date));
        }
        $task->description = $request->get('description');
        $task->assigned_by = Auth::user()->id;
        if ($request->amendment == null) {
            $task->amendment = 0;
        } else {

            $task->amendment = $request->amendment;


        }
        if ($parent) {
            $task->parent_id = $parent->id;

            $parent->child = 1;
            $parent->update();
        }
        $result = $task->save();

        if ($task->employee_id != null) {
            $user = User::where('employee_id', '=', $request->employee_id)->first();
            if ($user) {
                $task->assigned_to = $user->id;
                Notification::send($user, new TaskAssigned());
            }
        }


        if ($result) {
            return redirect('/project/' . $project_id)->with('message-success', 'New Task has been assigned.');
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

        $editData = ErpTask::find($id);
        $project = ErpProject::find($editData->project_id);
        $users = User::all();
        return view('backEnd.tasks.show', compact('editData', 'users'));
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
        $editData = ErpTask::find($id);
        $parents = ErpTask::select('id', 'task_id')->get();
        $users = User::all();
        $employees = ErpProjectEmployee::where('project_id', $editData->project_id)->where('employee_id', '!=', null)->get();
        $tasks = ErpTask::where('project_id', '=',  $editData->project_id)->get();
        $maxAmendment = 0;
        foreach ($tasks as $task) {

            if ($task->amendment > $maxAmendment) {
                $maxAmendment = $task->amendment;
            }
        }
        return view('backEnd.tasks.edit', compact('editData', 'parents', 'users', 'employees','maxAmendment'));
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
            'task_id' => 'required|string|min:1|max:20',
            'task_name' =>'required|string|min:3|max:200',
        ]);
        $parent = ErpTask::find($request->parent_id);

        $task = ErpTask::find($id);
        $task->task_id = $request->get('task_id');
        $task->task_name = $request->get('task_name');
        $task->employee_id = $request->get('employee_id');
        $task->priority = $request->get('priority');
        $task->task_status = $request->get('task_status');
        if($request->due_date != null){
            $task->due_date = date('Y-m-d', strtotime($request->due_date));
        }
        $task->description = $request->get('description');
        if ($request->amendment != null) {
            $task->amendment = $request->amendment;
        }
        $task->updated_by = Auth::user()->id;
        $project_id = $task->project_id;

        if($parent){
            $task->parent_id = $parent->id;

            $parent->child = 1;
            $parent->update();
        }
        $result = $task->update();

        if ($task->employee_id != null) {
            $user = User::where('employee_id', '=', $request->employee_id)->first();
            if ($user) {
                $task->assigned_to = $user->id;
                Notification::send($user, new TaskAssigned());
            }
        }

        if($result){
            return redirect('/project/'.$project_id )->with('message-success', 'Task has been updated.');
        } else {
            return redirect('/project/'.$project_id )->with('message-danger', 'Something went wrong. Please try again.');
        }
    }

    public function submitTaskView($id){
        return view('backEnd.tasks.modalViews.submitTaskView', compact('id'));
    }

    public function submitTask($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'submited','path'=>url()->current())
        );
        $task = ErpTask::find($id);
        $task->task_status = 'waiting';
        $result = $task->update();

        $user = User::find($task->assigned_by);
        Notification::send($user, new TaskSubmitted());

        if($result){
            return redirect()->back()->with('message-success-success', 'Task has been submitted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function confirmTaskView($id){
        return view('backEnd.tasks.modalViews.confirmTaskView', compact('id'));
    }

    public function confirmTask($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'confirmed','path'=>url()->current())
        );
        $task = ErpTask::find($id);
        $task->task_status = 'completed';
        $task->completed_on = Carbon::now()->toDateString();
        $task->active_status = 0;
        $task->updated_by = Auth::user()->id;
        $result = $task->update();

        $user = User::find($task->assigned_to);
        Notification::send($user, new TaskChecked());

        if($result){
            return redirect()->back()->with('message-success-success', 'Task has been completed successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function reassignTaskView($id){
        return view('backEnd.tasks.modalViews.reassignTaskView', compact('id'));
    }

    public function reassignTask($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'reassigned','path'=>url()->current())
        );
        $task = ErpTask::find($id);
        $task->task_status = 'reassigned';
        $task->updated_by = Auth::user()->id;
        $result = $task->update();

        $user = User::find($task->assigned_to);
        Notification::send($user, new TaskChecked());

        if($result){
            return redirect()->back()->with('message-success-delete', 'Task has been reassigned successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function deleteTaskView($id){
        return view('backEnd.tasks.modalViews.deleteTaskView', compact('id'));
    }

    public function deleteTask($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $task = ErpTask::find($id);
        $task->task_status = 'cancelled';
        $task->active_status = 0;
        $result = $task->update();

        if($result){
            return redirect()->back()->with('message-success-delete', 'Task has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function addToDo($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $project = ErpProject::find($id);
        return view('backEnd.tasks.addToDo', [
            'project' => $project,
            'phases' => ErpProjectPhase::where('required', 1)->orderBy('defined_id')->get(),
        ]);
    }

    public function saveToDo(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'project_phase' =>'required',
            'status'=> 'required',
            'task_group'=>'min:0|max:100',
            'task'=>'min:0|max:100',
        ]);

        $project_id = $request->get('project_id');

        $todo = new ErpProjectTodo();
        $todo->project_id = $project_id;
        $todo->project_phase = $request->get('project_phase');
        $todo->task_group = $request->get('task_group');
        $todo->task = $request->get('task');
        $todo->status = $request->get('status');
        if( $request->get('due_date') != ''){
            $todo->due_date = date('Y-m-d', strtotime($request->get('due_date')));
        }
        $todo->created_by = Auth::user()->id;
        $result = $todo->save();

        if($result){
            return redirect('/project/'.$project_id )->with('message-success', 'New Reminder has been assigned.');
        } else {
            return redirect('/project/'.$project_id )->with('message-success', 'Something went wrong. Please try again.');
        }
    }

    public function editToDo($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpProjectTodo::find($id);
        $phases = ErpProjectPhase::where('required', 1)->orderBy('defined_id')->get();
        return view('backEnd.tasks.addToDo', compact('editData', 'phases'));
    }

    public function updateToDo(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'project_phase' =>'required',
            'status'=> 'required',
            'task_group'=>'min:0|max:100',
            'task'=>'min:0|max:100',
        ]);

        $todo = ErpProjectTodo::find($id);
        $todo->project_phase = $request->get('project_phase');
        $todo->task_group = $request->get('task_group');
        $todo->task = $request->get('task');
        $todo->status = $request->get('status');
        if( $request->get('due_date') != ''){
            $todo->due_date = date('Y-m-d', strtotime($request->get('due_date')));
        }
        $todo->updated_by = Auth::user()->id;
        $project_id = $todo->project_id;

        $result = $todo->update();

        if($result){
            return redirect('/project/'.$project_id )->with('message-success', ' Reminder has been updated.');
        } else {
            return redirect('/project/'.$project_id )->with('message-danger', 'Something went wrong. Please try again.');
        }
    }

    public function deleteToDoView($id){
        return view('backEnd.tasks.modalViews.deleteTodoView', compact('id'));
    }

    public function deleteToDo($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $todo = ErpProjectTodo::find($id);
        $todo->active_status = 0;
        $result = $todo->update();

        if($result){
            return back()->with('message-success-delete', 'Task has been completed successfully');
        }else{
            return back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

}

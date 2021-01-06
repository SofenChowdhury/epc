<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ErpRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:Add/Edit Role|Assign Permission by Role')->only('index');
        $this->middleware('permission:Add/Edit Role')->only('create','edit','store','update');
        $this->middleware('permission:Assign Permission by Role')->only('assignPermission','rolePermissionStore');
    }

    public function index()
    {
//        $permission = Permission::create(['name' => 'Add/ Edit Conveyance Schedule', 'Module_name' => 'HR']);
        $roles = Role::all();
        return view('backEnd.roles.create', compact('roles'));
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
            'role_name'=>'required'
        ]);

        $role = Role::create(['name' => $request->get('role_name')]);
        return redirect('/role')->with('message-success', 'Role has been added');
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
        $role = Role::find($id);
        return view('backEnd.roles.edit', compact('role'));
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
            'name'=>'required'
        ]);
        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->save();
        return redirect('/role')->with('message-success', 'Role has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteRoleView($id){
        $module = 'deleteRole';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteRole($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $result = ErpRole::destroy($id);
        if($result){
            return redirect()->back()->with('message-success-delete', 'Role has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function assignPermission($role_id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'assigned','path'=>url()->current())
        );
        $role=Role::findById($role_id);
        if(Auth::user()->hasRole('Super Admin'))
            $permissions=Permission::orderBy('Module_name')->get();
        else{
            $permissions=Auth::user()->getAllPermissions();
        }
        $role_permissions=$role->getAllPermissions();
//        dd($role_permissions);
        $already_assigned = [];
        foreach($role_permissions as $role_permission){
            $already_assigned[] = $role_permission->id;
        }

        return view('backEnd.roles.assignPermission', compact('permissions','role','already_assigned'));
    }

    public function rolePermissionStore(Request $request){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $role=Role::findById($request->role_id);
        $role->syncPermissions($request->permissions);
        return redirect('role')->with('message-success-assign-role', 'Role permission has been assigned successfully');
    }
}

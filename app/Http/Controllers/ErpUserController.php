<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\ErpEmployee;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ErpUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View User List|Edit User|Delete User|Assign Permission by User')->only('index');
        $this->middleware('permission:Edit User|Delete User')->only('edit','store','update');
        $this->middleware('permission:Assign Permission by User')->only('assignPermission','userPermissionStore');
    }
    public function index()
    {
        $users = User::where('active_status', '=', 1)->where('id', '!=', '5')->get();
        return view('backEnd.users.userList', compact('users'));
    }

    public function suspended()
    {
        $users = User::where('active_status', '=', 0)->get();
        $suspend = 1;
        return view('backEnd.users.userList', compact('users', 'suspend'));
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
        $employee = ErpEmployee::find($id);
        $users = User::where('id', '!=', '5')->get();
        $roles = Role::all();
        return view('backEnd.users.create', compact('users','roles', 'employee'));
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
        // get all user employee_id
        $all_employee_id = User::get()->pluck('employee_id');

        $request->validate([
            'email' => 'required | unique:users,email,'.$request->get('email'),
            'password' => 'required'
        ]);

        //This foreach for checking if the user already exists, checking employee id in user table
        foreach ($all_employee_id as $key => $value) {
            if( $value == $request->get('employee_id') ) {
                return redirect('/employee')->with('message-danger', 'Sorry this user already exists.');
            }
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->get('email');
        $user->employee_id = $request->employee_id;
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        $user->created_by = Auth::user()->id;

        $user->assignRole($request->role_id);

        if($password == $password_confirmation) {
            $user->password = Hash::make( $request->get('password') );
            $user->save();
            $user->givePermissionTo('View Own Profile');
            return redirect('/employee')->with('message-success', 'User has been added');
        } else {
            return redirect()->back()->with('message-danger', 'Password does not match.');
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
        $editData = User::find($id);
        $roles = Role::all();
        return view('backEnd.users.edit', compact('editData', 'roles'));
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
        //get user hashed password
        $hashed_pass = User::find($id)->password;

        // $request->validate([
        //     'email'=> 'required|unique:users,email,'.$request->email,
        // ]);

        $user = User::find($id);
        $user->email = $request->get('email');
        $previous_password = $request->get('previous_password');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        $user->updated_by = Auth::user()->id;
        $user->syncRoles($request->role_id);

        // validate passwords for users
        if( $previous_password != '' && $password != '' && $password_confirmation != '') {
            if( $password == $password_confirmation ) {
                if( Hash::check( $previous_password, $hashed_pass) ) {
                    $user->password = Hash::make( $request->get('password') );
                    $user->save();
                    return redirect('/user')->with('message-success', 'User has been updated');
                } else {
                    return redirect('/user/'.$id.'/edit')->with('message-danger', 'Previous password does not match.');
                }
            } else {
                return redirect('/user/'.$id.'/edit')->with('message-danger', 'Password does not match.');
            }
        } else if( $previous_password == '' && $password == '' && $password_confirmation == '') {
            $user->password = $hashed_pass;
            $user->save();
            return redirect('/user')->with('message-success', 'User has been updated');
        } else {
            return redirect('/user/'.$id.'/edit')->with('message-danger', 'Check your password.');
        }
    }

    public function editPassword($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = User::find($id);
        $roles = Role::all();
        return view('backEnd.users.changePassword', compact('editData', 'roles'));
    }

    public function changePassword(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'changed','path'=>url()->current())
        );
        //get user hashed password
        $hashed_pass = User::find($id)->password;

        $user = User::find($id);
        $previous_password = $request->get('previous_password');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        $user->updated_at = Carbon::now();

        // validate passwords for users
        if( $previous_password != '' && $password != '' && $password_confirmation != '') {
            if( $password == $password_confirmation ) {
                if( Hash::check( $previous_password, $hashed_pass) ) {
                    $user->password = Hash::make( $request->get('password') );
                    $user->save();
                    return redirect('/employee/'.Auth::user()->employee_id)->with('message-success', 'Your Password has been Changed');
                } else {
                    return redirect('/user/editPassword/'.$id)->with('message-danger', 'Previous password does not match.');
                }
            }
            else {
                return redirect('/user/editPassword/'.$id)->with('message-danger', 'Password does not match.');
            }
        }
        else {
            return redirect('/user/editPassword/'.$id)->with('message-danger', 'Check your password.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserView($id){
        $module = 'deleteUser';
         return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteUser($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $user = User::find($id);
        $user->active_status = 0;
        $result = $user->update();
        if($result){
            return redirect()->back()->with('message-success-delete', 'User has been suspended successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function activeUserView($id){
         return view('backEnd.users.activateUserView', compact('id'));
    }

    public function activeUser($id){

        $user = User::find($id);
        $user->active_status = 1;
        $result = $user->update();

        if($result){
            return redirect('/user')->with('message-success', 'User has been activated successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }

    public function assignPermission($user_id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'assigned','path'=>url()->current())
        );
        $user=User::find($user_id);
        if(Auth::user()->hasRole('Super Admin'))
            $permissions=Permission::orderBy('Module_name')->get();
        else{
            $permissions=Auth::user()->getAllPermissions();
        }
        $user_permissions=$user->getAllPermissions();
        $already_assigned = [];
        foreach($user_permissions as $user_permission){
            $already_assigned[] = $user_permission->id;
        }

        return view('backEnd.users.assignPermission', compact('permissions','user','already_assigned'));
    }

    public function userPermissionStore(Request $request){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $user=User::find($request->user_id);
        $user->syncPermissions($request->permissions);
        return redirect('user')->with('message-success-assign-user', 'User permission has been assigned successfully');
    }

    public function allNotifications()
    {
        return view('backEnd.notifications.index');
    }


}

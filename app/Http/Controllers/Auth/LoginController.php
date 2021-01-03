<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ErpInventory;
use App\ErpProject;
use App\ErpTask;
use App\Notifications\InventoryShortage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskDeadline;
use App\Notifications\ProjectDeadline;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        if($user->id == 1 || $user->id == 19){
            $projects = ErpProject::where('active_status', '=', 1)
                ->whereBetween('project_due_date', array(date('Y-m-d', strtotime(Carbon::now())), date('Y-m-d', strtotime(Carbon::now()->addDays(7)))))
                ->get();
            if($projects) {
                foreach ($projects as $project) {
                    Notification::send($user, new ProjectDeadline($project));
                }
            }
        }
        else {
            $projects = ErpProject::where('active_status', '=', 1)
                ->where('project_director', '=', $user->id)
                ->orWhere('project_lead', '=', $user->id)
                ->whereBetween('project_due_date', array(date('Y-m-d', strtotime(Carbon::now())), date('Y-m-d', strtotime(Carbon::now()->addDays(7)))))
                ->get();
            if ($projects) {
                foreach ($projects as $project) {
                    Notification::send($user, new ProjectDeadline($project));
                }
            }
        }

        if($user->id == 1 || $user->id == 19){
            $inventories = ErpInventory::where('category', '=', 1)->where('quantity', '<=', 12)->get();
            $count = 0;
            if($inventories) {
                foreach ($inventories as $inventory) {
                    if($inventory->quantity <= $inventory->min_amount){
                        $count++;
                    }
                }
            }
            if ($count > 0)
                Notification::send($user, new InventoryShortage($count));
        }

        $tasks = ErpTask::where('assigned_to', '=', $user->id)
            ->orWhere('assigned_by', '=', $user->id)
            ->whereBetween('due_date', array(date('Y-m-d', strtotime(Carbon::now())), date('Y-m-d', strtotime(Carbon::now()->addDays(7)))))
            ->get();
        if ($tasks) {
            foreach ($tasks as $task) {
                $user->notify(new TaskDeadline($task));
            }
        }

        if ($user->active_status == 1) {
            return redirect('/');
        }
        else
            dd("Your account has been suspended. Please try again later.");
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}

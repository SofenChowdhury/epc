<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectEmployee extends Model
{
    public function project() {
        return $this->belongsTo('App\ErpProject','project_id','id');
    }

    public function ressign_project() {
        return $this->belongsTo('App\ErpProject','reassign','id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function employee() {
        return $this->belongsTo('App\ErpEmployee','employee_id','id');
    }
    
    //Number of projects an employee is working on
    public static function projects_working($id){
        $count = 0;
        $connected = ErpProjectEmployee::where('employee_id', $id)->distinct('project_id')->get(['project_id'])->count();
//        if ($connected)
//            $count = $connected->count();
        return $connected;
    }
}

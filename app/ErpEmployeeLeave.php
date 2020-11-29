<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Notification;
use App\Notifications\LeaveRequest;

class ErpEmployeeLeave extends Model
{
    use Notifiable;

    public function employee(){
		return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
	}

    public function leave_type(){
        return $this->belongsTo('App\ErpLeaveType', 'type_of_leave', 'id');
    }
}

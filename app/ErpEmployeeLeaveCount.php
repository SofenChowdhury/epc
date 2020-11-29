<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeLeaveCount extends Model
{
    public function employee(){
        return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
    }

    public function leave(){
        return $this->belongsTo('App\ErpLeaveType', 'leave_type_id', 'id');
    }
}

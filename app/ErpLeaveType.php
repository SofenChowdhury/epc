<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpLeaveType extends Model
{
    public function leave_count(){
        return $this->hasMany('App\ErpEmployeeLeaveCount', 'leave_type_id', 'id');
    }
}

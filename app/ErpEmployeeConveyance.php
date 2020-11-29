<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeConveyance extends Model
{
    public function employee() {
        return $this->belongsTo('App\ErpEmployee','employee_id','id');
    }
    
    public function creator() {
        return $this->belongsTo('App\User','created_by','id');
    }
    
    public function conveyance(){
        return $this->belongsTo('App\ErpConveyanceSchedule', 'conveyance_id', 'id');
    }
    
    public function project() {
        return $this->belongsTo('App\ErpProject','project_id','id');
    }
}

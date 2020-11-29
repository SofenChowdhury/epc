<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeAdvance extends Model
{
    public function employee() {
        return $this->belongsTo('App\ErpEmployee','employee_id','id');
    }
    
    public function creator() {
        return $this->belongsTo('App\User','created_by','id');
    }
}

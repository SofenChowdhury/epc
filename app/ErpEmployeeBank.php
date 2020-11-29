<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeBank extends Model
{
    public function employee() {
        return $this->belongsTo('App\ErpEmployee','employee_id','id');
    }
}

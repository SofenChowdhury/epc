<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeIndent extends Model
{
    public function employee(){
        return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
    }

    public function indenter(){
        return $this->belongsTo('App\ErpEmployee', 'created_by', 'id');
    }
}

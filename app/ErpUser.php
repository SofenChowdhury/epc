<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpUser extends Model
{
    public function employee(){
		return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpTask extends Model
{
	public function project(){
		return $this->belongsTo('App\ErpProject', 'project_id', 'id');
	}

    public function employee(){
        return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
    }

	public function user(){
		return $this->belongsTo('App\User', 'assigned_to', 'id');
	}

    public function assignee(){
        return $this->belongsTo('App\User', 'assigned_by', 'id');
    }
}

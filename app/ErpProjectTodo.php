<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectTodo extends Model
{
    public function project(){
		return $this->belongsTo('App\ErpProject', 'project_id', 'id');
	}
}

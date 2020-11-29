<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectPhaseDetail extends Model
{
    public function project(){
		return $this->belongsTo('App\ErpProject', 'project_id', 'id');
	}
}

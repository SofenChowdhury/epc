<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectJointVenture extends Model
{
    public function project(){
		return $this->belongsTo('App\ErpProject', 'project_id', 'id');
	}
}

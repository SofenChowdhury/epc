<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectReporting extends Model
{
    public function project(){
        return $this->belongsTo('App\ErpProject', 'project_id', 'id');
    }
}

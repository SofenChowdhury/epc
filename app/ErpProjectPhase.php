<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectPhase extends Model
{
    public function projects() {
        return $this->hasMany('App\ErpProject','project_phase','defined_id');
    }
}

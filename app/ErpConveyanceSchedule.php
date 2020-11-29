<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpConveyanceSchedule extends Model
{
    public function conveyances(){
        return $this->hasMany('App\ErpEmployeeConveyance', 'conveyance_id', 'id');
    }
}

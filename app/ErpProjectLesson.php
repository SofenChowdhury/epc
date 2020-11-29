<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectLesson extends Model
{
    public function project() {
        return $this->belongsTo('App\ErpProject','project_id','id');
    }

    public function user() {
        return $this->belongsTo('App\User','created_by','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpLocation extends Model
{
    public function employee(){
        return $this->hasMany('App\ErpEmployee', 'location', 'id');
    }

    public function inventory(){
        return $this->hasMany('App\ErpInventory', 'location', 'id');
    }
}

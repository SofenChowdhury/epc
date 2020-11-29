<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpRoomNo extends Model
{
    public function employee(){
        return $this->hasMany('App\ErpEmployee', 'room_no', 'id');
    }

    public function inventory(){
        return $this->hasMany('App\ErpInventory', 'room_no', 'id');
    }
}

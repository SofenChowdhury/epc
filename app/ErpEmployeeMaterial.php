<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpEmployeeMaterial extends Model
{
    public function employee() {
        return $this->belongsTo('App\ErpEmployee','employee_id','id');
    }

    public function driver() {
        return $this->belongsTo('App\ErpEmployee','driver_id','id');
    }

    public function inventory() {
        return $this->belongsTo('App\ErpInventory','inventory_id','id');
    }

    public function location() {
        return $this->belongsTo('App\ErpLocation','location','id');
    }

    public function room() {
        return $this->belongsTo('App\ErpRoomNo','room_no','id');
    }

    public function coa() {
        return $this->belongsTo('App\ErpChartOfAccounts','coa_id','id');
    }
}

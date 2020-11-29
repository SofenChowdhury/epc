<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectMaterial extends Model
{
    public function inventory() {
        return $this->belongsTo('App\ErpInventory','inventory_id','id');
    }

    public function product(){
        return $this->belongsTo('App\ErpProduct', 'product_id', 'id');
    }

    public function coa() {
        return $this->belongsTo('App\ErpChartOfAccounts','coa_id','id');
    }

    public function ressigned() {
        return $this->belongsTo('App\ErpProject','reassign','id');
    }
}

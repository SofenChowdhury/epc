<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpVendor extends Model
{
    public function coa() {
        return $this->belongsTo('App\ErpChartOfAccounts','coa_id','id');
    }

    public function bank() {
        return $this->hasOne('App\ErpVendorBank','vendor_id','id');
    }

    public function documents() {
        return $this->hasMany('App\ErpVendorDocument','vendor_id','id');
    }

    public function inventories(){
        return $this->hasMany('App\ErpInventory', 'vendor_id', 'id');
    }
}

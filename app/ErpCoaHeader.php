<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpCoaHeader extends Model
{
    public function category(){
        return $this->belongsTo('App\ErpAccountsCategory', 'category_id', 'category_reference_no');
    }
    public function coa() {
        return $this->hasMany('App\ErpChartOfAccounts','coa_header_id','header_reference_no');
    }
}

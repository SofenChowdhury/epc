<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpChartOfAccounts extends Model
{
    public function header(){
        return $this->belongsTo('App\ErpCoaHeader', 'coa_header_id', 'header_reference_no');
    }

    public function children() {
        return $this->hasMany(self::class, 'coa_parent', 'coa_reference_no');
    }

    public function parent() {
        return $this->belongsTo(self::class, 'coa_parent', 'coa_reference_no');
    }

    public function transaction_details() {
        return $this->hasMany('App\ErpTransactionDetails', 'coa_id', 'id');
    }
}

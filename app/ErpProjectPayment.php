<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProjectPayment extends Model
{
    public function account() {
        return $this->belongsTo('App\ErpChartOfAccounts','coa_id','id');
    }

    public function transaction() {
        return $this->belongsTo('App\ErpTransaction','transaction_id','id');
    }

    public function detail() {
        return $this->belongsTo('App\ErpTransactionDetails','transaction_detail_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpTransactionDetails extends Model
{
    protected $fillable = ['coa_id', 'debit_amount', 'credit_amount', 'type', 'created_by'];

    public function account() {
        return $this->belongsTo('App\ErpChartOfAccounts','coa_id','id');
    }

    public function transaction() {
        return $this->belongsTo('App\ErpTransaction','transaction_id','id');
    }
}

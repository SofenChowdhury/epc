<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ErpTransaction extends Model
{
    use Notifiable;

    protected $fillable = [
        'transaction_date',
        'voucher_no',
        'project_id',
        'description',
        'total_transaction',
        'active_status',
        'created_by'
    ];

    public function transactionDetail() {
        return $this->hasMany('App\ErpTransactionDetails','transaction_id','id');
    }



}

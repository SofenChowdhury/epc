<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpAccountsCategory extends Model
{
    public function header() {
        return $this->hasMany('App\ErpCoaHeader','category_id','category_reference_no');
    }
}

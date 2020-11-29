<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProduct extends Model
{
    public function inventories(){
        return $this->hasMany('App\ErpInventory', 'product_id', 'id');
    }

    public function materials(){
        return $this->hasMany('App\ErpProjectMaterial', 'product_id', 'id');
    }
}

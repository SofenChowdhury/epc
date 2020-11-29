<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpModule extends Model
{
    public function moduleLink(){
    	return $this->hasMany('App\ErpModuleLinks', 'module_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Erp_role_permissions extends Model
{
    public  function moduleLink(){
    	return $this->belongsTo('App\ErpModuleLinks', 'module_link_id', 'id');
    } 
}

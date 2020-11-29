<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpInventory extends Model
{
    public function product(){
        return $this->belongsTo('App\ErpProduct', 'product_id', 'id');
    }

    public function employee(){
		return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
	}

    public function driver(){
        return $this->belongsTo('App\ErpEmployee', 'driver_id', 'id');
    }

	public function project(){
		return $this->belongsTo('App\ErpProject', 'project_id', 'id');
	}

	public function coa(){
		return $this->belongsTo('App\ErpChartOfAccounts', 'coa_id', 'id');
	}

    public function location(){
        return $this->belongsTo('App\ErpLocation', 'location', 'id');
    }

    public function room(){
        return $this->belongsTo('App\ErpRoomNo', 'room_no', 'id');
    }

    public function vendor(){
        return $this->belongsTo('App\ErpVendor', 'vendor_id', 'id');
    }
    public function depreciations()
    {
        return $this-> hasOne('App\ErpDepreciation','product_id','id');
    }

}

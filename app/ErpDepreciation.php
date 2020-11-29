<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ErpDepreciation extends Model
{
    public static function depreciation_calculate(){
        $assets = ErpDepreciation::where('active_status', '=', 1)->get();

        foreach ($assets as $asset){

            $d = date('Y', strtotime($asset->purchase_date));
            if($d == Carbon::now()->format('Y')){
                $present_month = Carbon::now()->format('m') - date('m', strtotime($asset->purchase_date));
            }else{
                $present_month = Carbon::now()->format('m');
            }
            // dd($present_month);
            $month_difference = Carbon::now()->diffInMonths($asset->purchase_date);
            $annual_cost = $asset->cost_price;
            $accumulated_dep = 0;
            $yrs = $mnths = '';

            if($month_difference > 12){
                $yrs = floor($month_difference / 12);
                $mnths = $month_difference % 12;
            }else{
                $mnths = $month_difference;
            }

            if($yrs > 0){
                while($yrs>0){
                    $annual_d = ($annual_cost * $asset->depreciation_rate)/100;
                    $accumulated_dep += $annual_d;
                    $annual_cost -= $annual_d;
                    $yrs--;
                }
            }
            if($mnths > 0){
                $monthly_d = (($annual_cost*$asset->depreciation_rate)/100)/12;
                $total_monthly_d = $monthly_d * $mnths;
                $accumulated_dep += $total_monthly_d;
                $annual_cost -= $total_monthly_d;
                $current_dep = $present_month * $monthly_d;
            }else{
                $current_dep = $present_month * ((($annual_cost*$asset->depreciation_rate)/100)/12);
            }

//            dd($accumulated_dep);
            $asset->current_value = $annual_cost;
            $asset->accumulated_depreciation = $accumulated_dep;
            $asset->current_year_dep = $current_dep;
            $asset->update();
        }
    }

    public function inventories()
    {
        return $this-> hasOne('App\ErpInventory','id','product_id');
    }

}

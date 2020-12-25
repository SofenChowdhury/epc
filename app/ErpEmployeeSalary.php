<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ErpEmployeeSalary extends Model
{
    //
    protected $fillable=['employee_id','basic','basic_percentage','conveyance','medical','medical_percentage','tax_amount','tax_payable', 'increment', 'increment_date', 'total_salary','created_by'];
    
    public static function tax_calc($id, $gross){
        $basic = $gross * 0.4;                  //  40% of gross salary
        $yearly_basic = $basic * 12;
        $tax_val = 0;
        $remaining = $yearly_basic - 300000; //first 300k no tax, so deducted
        
        if($remaining>0){
            if($remaining>100000){          //on next 1 lac, 5% tax (eg, 5% of 100000 = 5000)
                $remaining -= 100000;
                $tax_val = 5000;
            }
            else{
                $tax = (5 * $remaining)/100;
                $tax_val += $tax;
                $remaining = 0;
            }
        }
        
        if($remaining>0){                   //on next 3 lacs, 10% tax (eg, 10% of 300000 = 30000)
            if($remaining>300000){
                $remaining -= 300000;
                $tax_val += 30000;
            }
            else{
                $tax = (10 * $remaining)/100;
                $tax_val += $tax;
                $remaining = 0;
            }
        }
        
        if($remaining>0){                   //on next 4 lacs, 15% tax (eg, 15% of 400000 = 60000)
            if($remaining>400000){
                $remaining -= 400000;
                $tax_val += 60000;
            }
            else{
                $tax = (15 * $remaining)/100;
                $tax_val += $tax;
                $remaining = 0;
            }
        }
        
        if($remaining>0){                   //on next 5 lacs, 20% tax (eg, 20% of 500000 = 100000)
            if($remaining>500000){
                $remaining -= 500000;
                $tax_val += 100000;
            }
            else{
                $tax = (20 * $remaining)/100;
                $tax_val += $tax;
                $remaining = 0;
            }
        }
        
        if($remaining>0){                    //on remaining balance, 25% tax
            $tax = (25 * $remaining)/100;
            $tax_val += $tax;
        }
        
        $salary = ErpEmployeeSalary::where('employee_id', $id)->latest()->first();
        if ($salary){
            $salary->tax_amount=($tax_val/12);
            $salary->tax_payable = ((80 * $salary->tax_amount)/100);
            $tax_payable = $salary->tax_payable;
            $salary->update();
            return $tax_payable;
        }
        return 0;
        
    }
    
    public static function hourly_calc($id){
        $salary = ErpEmployeeSalary::where('employee_id', '=', $id)->latest()->first();
        
        if(isset($salary->basic)){
            $basic = $salary->basic;
        } else{
            $basic = 0;
        }
        $hourly = ($basic * 12) / 2080;

//        $salary->hourly_rate=$hourly;
//        $salary->update();
        return $hourly;
    }
    
    
    public static function tax_certificate($id, $start, $end, $project_id){
        $starting = Carbon::parse($start);
        
        $ending = Carbon::parse($end);
        
        $month_diff = $starting->diffInMonths($ending) + 1;
        
        $sal_month = $starting;
        $present_salary = $basic = $money = $amount = $advance_amount = $conveyance = $weekdays = $holidays = $provident_fund = 0;
        $gross = $total_deduction = $before_tax = $tax_payable = $net_salary = 0;
        $eid = $annual = $transport= $mobile = $other = $ot_food = $ot_conveyance = $ot_pay = $ot_time = 0;
        for(; $month_diff; $month_diff--){
            $weekdays= ErpEmployeeAttendance::weekdays($sal_month);
            $salary = ErpEmployeeSalary::where('employee_id','=',$id)->latest()->first();
            $overtime = ErpEmployeeAttendance::overtime_calc($id, $sal_month);
            
            $bonuses = ErpEmployeeBonus::where('employee_id','=',$id)->where('created_at', 'like', date('Y-m', strtotime($sal_month)). '%')->orWhere('every_month', '=', 1)->where('employee_id','=',$id)->get();

//            $bonuses = ErpEmployeeBonus::where('employee_id','=',$id)->where('created_at', 'like', date('Y-m', strtotime($sal_month)). '%')->orWhere('every_month', '=', 1)->get();
          
            $advances = ErpEmployeeAdvance::where('employee_id','=',$id)->whereMonth('from_month', '<=', date('m', strtotime($sal_month)))->whereMonth('to_month', '>=', date('m', strtotime($sal_month)))->get();
            $conveyance_pays = ErpEmployeeConveyance::where('employee_id','=',$id)->where('pay_date', 'like', date('Y-m', strtotime($sal_month)). '%')->get();
            $overtime_pay = ErpEmployeeOvertimePay::where('employee_id','=',$id)->where('pay_date', 'like', date('Y-m', strtotime($sal_month)). '%')->get();
            $attended = ErpEmployeeAttendance::attendance_calc($id, $sal_month);
            if ($salary){
                $present_salary += ceil(($weekdays / $weekdays) * $salary->total_salary);
            }
            
            
            foreach($bonuses as $bonus) {
                if ($bonus->bonus_title == 'Eid bonus') {
                    $eid += $bonus->amount;
                    $amount += $bonus->amount;
                    
                }
                if ($bonus->bonus_title == 'Annual Bonus') {
                    $annual += $bonus->amount;
                    $amount += $bonus->amount;
                }
                if ($bonus->bonus_title == 'Transport Allowance') {
                    $transport += $bonus->amount;
                    $amount += $bonus->amount;
                    
                }
                if ($bonus->bonus_title == 'Mobile Allowance') {
                    $mobile += $bonus->amount;
                    $amount += $bonus->amount;
                    
                }
                if ($bonus->bonus_title == 'Other') {
                    $other += $bonus->amount;
                    $amount += $bonus->amount;
                    
                }
                
            }
            foreach($advances as $advance)
                $advance_amount += $advance->monthly_repay;
            foreach($overtime_pay as $pay){
                if ($pay->overtime_pay_name == 'conveyance') {
                    $ot_conveyance += $pay->amount;
                    $money += $pay->amount;
                }
                if ($pay->overtime_pay_name == 'food') {
                    $ot_food += $pay->amount;
                    $money += $pay->amount;
                }
                if ($pay->overtime_pay_name == 'pay') {
                    $ot_pay += $pay->amount;
                    $money += $pay->amount;
                }
            }
            foreach($conveyance_pays as $conveyance_pay) {
                if ($conveyance_pay->amount != null)
                    $conveyance += $conveyance_pay->amount;
                else
                    $conveyance += $conveyance_pay->conveyance->rate;
            }
            $ot_time += ceil($overtime->total_overtime);
            $money += ceil($overtime->total_overtime);
            if ($salary){
                $provident_fund += $salary->provident_fund;
            }
            
            
            $sal_month->addMonth(1);
        }
        
        $basic = $present_salary * 0.4;
        $total_deduction += $provident_fund + $advance_amount;
        $gross += ($present_salary + $money + $amount);
        $tax_payable += ErpEmployeeSalary::tax_calc($id, $gross);
        if ($tax_payable){
            $tax_payable = ceil($tax_payable);
//            $tax_payable += $salary->tax_payable;
            $net_salary += $gross - $total_deduction - $tax_payable + $conveyance;
        }
        $division = ErpEmployeeSalaryDivision::where('employee_id', '=', $id)->where('project_id', '=', $project_id)->latest()->first();
        if ($project_id != 1 && $division){
            $result = array(
                'present_salary' => $present_salary * $division->hour_percentage / 100,
                'basic' => $basic * $division->hour_percentage / 100,
                'weekdays' => $weekdays,
                'holidays' => $holidays,
                'bonus' => $amount * $division->hour_percentage / 100,
                'eid_bonus' => $eid * $division->hour_percentage / 100,
                'annual_bonus' => $annual * $division->hour_percentage / 100,
                'transport_allowance' => $transport * $division->hour_percentage / 100,
                'mobile_allowance' => $mobile * $division->hour_percentage / 100,
                'other_allowance' => $other * $division->hour_percentage / 100,
                'advance' => $advance_amount * $division->hour_percentage / 100,
                'conveyance' => $conveyance * $division->hour_percentage / 100,
                'overtime' => $money * $division->hour_percentage / 100,
                'ot_time' => $ot_time * $division->hour_percentage / 100,
                'ot_conveyance' => $ot_conveyance * $division->hour_percentage / 100,
                'ot_food' => $ot_food * $division->hour_percentage / 100,
                'ot_pay' => $ot_pay * $division->hour_percentage / 100,
                'provident_fund' => $provident_fund * $division->hour_percentage / 100,
                'gross' => $gross * $division->hour_percentage / 100,
                'total_deduction' => $total_deduction * $division->hour_percentage / 100,
                'tax_payable' => $tax_payable * $division->hour_percentage / 100,
                'net_salary' => $net_salary * $division->hour_percentage / 100
            );
        }
        else {
            $result = array(
                'present_salary' => $present_salary,
                'basic' => $basic,
                'weekdays' => $weekdays,
                'holidays' => $holidays,
                'bonus' => $amount,
                'eid_bonus' => $eid,
                'annual_bonus' => $annual,
                'transport_allowance' => $transport,
                'mobile_allowance' => $mobile,
                'other_allowance' => $other,
                'advance' => $advance_amount,
                'conveyance' => $conveyance,
                'overtime' => $money,
                'ot_time' => $ot_time,
                'ot_conveyance' => $ot_conveyance,
                'ot_food' => $ot_food,
                'ot_pay' => $ot_pay,
                'provident_fund' => $provident_fund,
                'gross' => $gross,
                'total_deduction' => $total_deduction,
                'tax_payable' => $tax_payable,
                'net_salary' => $net_salary
            );
        }
        return (object) $result;
    }
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ErpEmployeeAttendance extends Model
{
    public function employee(){
		return $this->belongsTo('App\ErpEmployee', 'employee_id', 'id');
	}

	public static function weekdays($id){
        Carbon::setWeekendDays([
            Carbon::FRIDAY,
            Carbon::SATURDAY,
        ]);
        $dateDay = date('Y-m-d', strtotime($id));
        $year = date('Y', strtotime($id));
        $month = date('m', strtotime($id));
        $days = Carbon::parse($dateDay)->daysInMonth;
        $weekdays=0;
        foreach (range(1, $days) as $day) {
            $date = Carbon::createFromDate($year, $month, $day);
            if ($date->isWeekday()===true) {
                $weekdays++;
            }
        }
        return $weekdays;
    }

	public static function attendance_calc($id, $month){
        $days = ErpEmployeeAttendance::where('employee_id', '=', $id)
            ->where('attendance_date', 'like', date('Y-m', strtotime($month)). '%')
            ->get()
            ->count();
        return $days;
    }

    public static function sick_leaves($id, $month){
        $leaves = ErpEmployeeLeave::where('employee_id', '=', $id)
            ->where('type_of_leave', '=', 3)
            ->get();
//        foreach ($leaves as $leave){
//            if ($leave->start_date )
//        }

//        ->whereMonth('start_date', strtotime($month))

        return $leaves;
    }

	public static function overtime_calc($id, $month){
        $salary = ErpEmployeeSalary::where('employee_id', '=', $id)->latest()->first();
        $attendances = ErpEmployeeAttendance::where('employee_id', '=', $id)->where('attendance_date', 'like', date('Y-m', strtotime($month)). '%')->get();
        $overtimes = Carbon::now()->setTime(0,0)->format('H:i');
        foreach ($attendances as $attendance){
            if($attendance->overtime != null){
                $overtimes = date('H:i', strtotime($overtimes) + strtotime($attendance->overtime));
            }
        }
        if(isset($salary->basic)){
            $basic = $salary->basic;
        } else{
            $basic = 0;
        }

        $hourly = ($basic * 12) / 2080;
        $overtime_hours = $hourly * date('H', strtotime($overtimes)) * 1;
        $overtime_minutes = ( $hourly * (date('i', strtotime($overtimes))) / 60) * 1;

        $total_overtime = $overtime_hours + $overtime_minutes;

        $result = array(
            'overtime_hours' => $overtimes,
            'total_overtime' => $total_overtime
        );
        return (object) $result;
    }


}

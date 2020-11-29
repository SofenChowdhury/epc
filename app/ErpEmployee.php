<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ErpEmployee extends Model
{
	use Notifiable;

    public function department(){
		return $this->belongsTo('App\ErpDepartment', 'department_id', 'id');
	}

	public function designation(){
		return $this->belongsTo('App\ErpDesignation', 'designation_id', 'id');
	}

    public function location(){
        return $this->belongsTo('App\ErpLocation', 'location', 'id');
    }

    public function room(){
        return $this->belongsTo('App\ErpRoomNo', 'room_no', 'id');
    }

	public function type(){
		return $this->belongsTo('App\ErpEmployeeType', 'employee_type', 'id');
	}

	public function category(){
		return $this->belongsTo('App\ErpEmployeeCategory', 'employee_category_id', 'id');
	}

	public function bank() {
        return $this->hasOne('App\ErpEmployeeBank','employee_id','id');
    }

	public function family() {
        return $this->hasOne('App\ErpEmployeeFamily','employee_id','id');
    }

    public function documents() {
        return $this->hasMany('App\ErpEmployeeDocument','employee_id','id');
    }

    public function leave_count(){
        return $this->hasMany('App\ErpEmployeeLeaveCount', 'employee_id', 'id');
    }

    public function educations() {
        return $this->hasMany('App\ErpEmployeeEducation','employee_id','id');
    }

	public function experiences() {
        return $this->hasMany('App\ErpEmployeeWorkExperience','employee_id','id');
    }

    public function salary(){
        return $this->hasMany('App\ErpEmployeeSalary','employee_id','id');
    }

    public function attendances(){
        return $this->hasMany('App\ErpEmployeeAttendance','employee_id','id');
    }

    public function leaves() {
        return $this->hasMany('App\ErpEmployeeLeave','employee_id','id');
    }

	public function tasks() {
        return $this->hasMany('App\ErpTask','employee_id','id');
    }

    public function projects() {
        return $this->hasMany('App\ErpProjectEmployee','employee_id','id');
    }

    public function materials() {
        return $this->hasMany('App\ErpEmployeeMaterial','employee_id','id');
    }

    public function cars() {
        return $this->hasMany('App\ErpEmployeeMaterial','driver_id','id');
    }
}

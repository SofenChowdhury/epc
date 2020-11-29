<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErpProject extends Model
{
    public function components() {
        return $this->belongsTo('App\ErpProjectComponent','project_component','id');
    }

    public function coa() {
        return $this->hasMany('App\ErpChartOfAccounts','project_id','id');
    }

    public function phase_name() {
        return $this->belongsTo('App\ErpProjectPhase','project_phase','defined_id');
    }

    public function phase() {
        return $this->hasMany('App\ErpProjectPhaseDetail','project_id','id');
    }

    public function joint_ventures() {
        return $this->hasMany('App\ErpProjectJointVenture','project_id','id');
    }

    public function clients() {
        return $this->belongsTo('App\ErpClient','client_id','id');
    }

    public function funded() {
        return $this->belongsTo('App\ErpClient','funded_by','id');
    }

    public function project_employees() {
        return $this->hasMany('App\ErpProjectEmployee','project_id','id');
    }

    public function materials() {
        return $this->hasMany('App\ErpProjectMaterial','project_id','id');
    }

    public function advances() {
        return $this->hasMany('App\ErpProjectAdvances','project_id','id');
    }
    public function progresses() {
        return $this->hasMany('App\ErpProjectProgressPayment','project_id','id');
    }

    public function budgets() {
        return $this->hasMany('App\ErpProjectBudget','project_id','id');
    }

    public function payments() {
        return $this->hasMany('App\ErpProjectPayment','project_id','id');
    }

    public function task() {
        return $this->hasMany('App\ErpTask','project_id','id');
    }

    public function reporting() {
        return $this->hasMany('App\ErpProjectReporting','project_id','id');
    }

    public function deliverable() {
        return $this->hasMany('App\ErpProjectDeliverable','project_id','id');
    }

    public function documents() {
        return $this->hasMany('App\ErpProjectDocument','project_id','id');
    }

    public function lessons() {
        return $this->hasMany('App\ErpProjectLesson','project_id','id');
    }

    public function sign_offs() {
        return $this->hasMany('App\ErpProjectSignoff','project_id','id');
    }

    public function checklist() {
        return $this->hasOne('App\ErpProjectChecklist','project_id','id');
    }

}

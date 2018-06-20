<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mediator extends Model
{
    protected $fillable = [
        'employee_id', 'position_id', 'department_id', 'wage', 'recruitment_event_id', 'recruitment_date'
    ];

    public function event()
    {
        return $this->belongsTo('App\Event', 'recruitment_event_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function employeeFullName()
    {
        return $this->employee->fullName();
    }

    public function subMediators()
    {
        return $this->employee->department->subMediators();
    }
}

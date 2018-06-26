<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mediator extends Model
{
    protected $fillable = [
        'employee_id', 'position_id', 'department_id', 'wage', 'recruitment_event_id', 'recruitment_date', 'is_archive'
    ];

    public function event()
    {
        return $this->belongsTo('App\Event', 'recruitment_event_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
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

    public function dissociateDepartment()
    {
        if ($this->department) {
            $this->department->employee()->dissociate()->save();
        }
    }

    public function dissociateSubDepartment()
    {
        if ($this->employee->department) {
            $this->employee->department->employee()->dissociate()->save();
        }
    }

    public function translateSubMediators()
    {
        $this->dissociateSubDepartment();

        $subMediators = $this->subMediators();
        foreach ($subMediators as $subMediator) {
            (new \App\Event)->create([
                'employee_id' => $subMediator->employee_id,
                'description' => 'Перевод сотрудника из подразделения ' .
                    $subMediator->department->name .
                    ' в подразделение ' .
                    $this->department->name,
                'department_id' => $this->department_id
            ]);

            $subMediator->update(['department_id' => $this->department_id]);
        }
    }

    public function subMediators()
    {
        if ($this->employee->department) {
            return $this->employee->department->subMediators();
        }
        return [];
    }

    public function headEmployeeFullName()
    {
        if (! $this->department->employee) {return null;}
        return $this->department->employee->fullName();
    }

    public function employeePhone()
    {
        return $this->employee->phone;
    }

    public function employeeEmail()
    {
        return $this->employee->email;
    }

    public function departmentName()
    {
        return $this->department->name;
    }

    public function positionName()
    {
        return $this->position->name;
    }

    public function setArchive()
    {
        if ($this->department) {
            $this->department()->dissociate()->save();
        }
        $this->is_archive = true;
        $this->save();
    }

    public function unsetArchive()
    {
        $this->is_archive = false;
        $this->save();
    }
}

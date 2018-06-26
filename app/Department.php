<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'description', 'head_employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'head_employee_id');
    }

    public function mediators()
    {
        return $this->hasMany('App\Mediator')->where('is_archive', 0);
    }

    public function subMediators()
    {
        return $this->mediators->all();
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
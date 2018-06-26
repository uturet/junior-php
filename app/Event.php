<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'description', 'employee_id', 'department_id', 'position_id', 'wage', 'is_archive'
    ];

    public function mediators()
    {
        return $this->hasMany('App\Mediator', 'recruitment_event_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function mediator()
    {
        return $this->hasOne('App\Mediator', 'recruitment_event_id');
    }

    public function createdDate()
    {
        return $this->created_at->format('j.m.Y');
    }
}

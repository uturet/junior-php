<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'description', 'employee_id'
    ];

    public function mediators()
    {
        return $this->hasMany('App\Mediator', 'recruitment_event_id');
    }
}

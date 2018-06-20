<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function mediators()
    {
        return $this->hasMany('App\Mediator');
    }

    public function subMediators()
    {
        return $this->mediators->all();
    }
}
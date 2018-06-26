<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'last_name', 'patronymic'
    ];

    protected $appends = ['full_name'];
    protected $hidden = ['name', 'last_name', 'patronymic'];

    public function getFullNameAttribute()
    {
        return $this->attributes['full_name'] = join(' ', [
            $this->last_name,
            $this->name,
            $this->patronymic,
        ]);
    }

    public function events()
    {
        return $this->hasMany('App\Event')->orderBy('id', 'desc');
    }

    public function mediator()
    {
        return $this->hasOne('App\Mediator');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'head_employee_id');
    }
}

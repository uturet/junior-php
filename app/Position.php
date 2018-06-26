<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function mediators()
    {
        return $this->hasMany('App\Mediator')->where('is_archive', 0);
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}

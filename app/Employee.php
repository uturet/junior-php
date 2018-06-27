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

    public function getImage()
    {
        if (!$this->photo_url) {
            return "/uploads/avatars/no_avatar.png";
        }
        return "/uploads/avatars/$this->photo_url";
    }

    public function uploadImage($image)
    {
        if($image == null) { return; }

        $this->removeImage();
        $fileName = str_random(30). '.' . $image->extension();
        $image->move('uploads/avatars', $fileName);
        $this->photo_url = $fileName;
        $this->save();
    }

    public function removeImage()
    {
        if($this->image != null) {
            Storage::delete('uploads/avatars/' . $this->photo_url);
        }
    }
}

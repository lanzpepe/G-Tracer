<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function image()
    {
        $path = $this->gender == 'Male' ? asset('storage/defaults/default_avatar_m.png') : asset('storage/defaults/default_avatar_f.png');

        return $path;
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id')->latest();
    }

    public function academic()
    {
        return $this->hasOne(Academic::class, 'user_id');
    }

    public function employments()
    {
        return $this->hasMany(Employment::class, 'user_id')->latest();
    }

    public function socialAccount()
    {
        return $this->hasOne(SocialAccount::class, 'user_id');
    }

    public function graduate()
    {
        return $this->hasOne(Graduate::class, 'user_id');
    }

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'user_graduate', 'user_id', 'graduate_id')->withPivot('response_id')->withTimestamps()->latest();
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'user_graduate', 'user_id', 'response_id')->withPivot('graduate_id')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->latest();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }
}

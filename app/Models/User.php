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

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'user_company', 'user_id', 'company_id')
            ->as('employment')->withPivot('job_position', 'date_employed')->withTimestamps()->latest();
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class, 'user_id');
    }

    public function preference()
    {
        return $this->hasOne(Preference::class, 'user_id');
    }

    public function achievement()
    {
        return $this->hasOne(Achievement::class, 'user_id');
    }

    public function graduate()
    {
        return $this->hasOne(Graduate::class, 'user_id');
    }

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'user_graduate', 'user_id', 'graduate_id')
            ->as('respondent')->withPivot('response_id')->withTimestamps()->latest();
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'user_graduate', 'user_id', 'response_id')
            ->as('respondent')->withPivot('graduate_id')->withTimestamps()->latest();
    }

    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'user_reward', 'user_id', 'reward_id')
            ->withPivot('id', 'status')->withTimestamps()->latest();
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getImageAttribute()
    {
        return $this->gender == 'Male' ? asset('storage/defaults/default_avatar_m.png') :
                asset('storage/defaults/default_avatar_f.png');
    }

    public function routeNotificationForFcm($notification)
    {
        return $this->device_token;
    }
}

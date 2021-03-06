<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'admin_id';
    protected $guarded = [];
    public $incrementing = false;

    public static function authUser()
    {
        return Admin::find(Auth::user()->admin_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role', 'admin_id', 'role_id')->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'admin_department', 'admin_id', 'dept_id')->withTimestamps();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'admin_school', 'admin_id', 'school_id')->withTimestamps();
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'admin_page', 'admin_id', 'page_id')->withTimestamps();
    }

    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'admin_reward', 'admin_id', 'reward_id')->withPivot('quantity')->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->middle_name} {$this->user->last_name}";
    }

    public function getDepartmentAttribute()
    {
        return $this->departments->first()->name;
    }

    public function getSchoolAttribute()
    {
        return $this->schools->first()->name;
    }

    public function getRoleAttribute()
    {
        return $this->roles->first()->name;
    }

    public function routeNotificationForFcm($notification)
    {
        return $this->user->device_token;
    }
}

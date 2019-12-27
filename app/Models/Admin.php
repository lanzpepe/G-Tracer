<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'admin_id';
    protected $guarded = [];
    public $incrementing = false;

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
}
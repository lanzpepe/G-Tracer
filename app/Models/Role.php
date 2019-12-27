<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_role', 'role_id', 'admin_id')->withTimestamps();
    }
}

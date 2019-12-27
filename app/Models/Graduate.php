<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'graduate_id';
    public $incrementing = false;

    public function tasks()
    {
        return $this->hasMany(GraduateTask::class, 'graduate_id')->latest();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'added_graduates', 'graduate_id',
            'user_id')->withTimestamps();
    }
}

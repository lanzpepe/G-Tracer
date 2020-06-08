<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_reward', 'reward_id', 'user_id')->withPivot('id', 'status')->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_reward', 'reward_id', 'admin_id')->withPivot('quantity')->withTimestamps();
    }

    public function getQuantityAttribute()
    {
        return $this->admins->first()->pivot->quantity;
    }
}

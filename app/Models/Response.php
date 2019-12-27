<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'response_id';
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'added_graduates', 'response_id',
            'user_id')->withTimestamps();
    }
}

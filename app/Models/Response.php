<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'response_id';
    public $incrementing = false;

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'user_graduate', 'response_id', 'graduate_id')->withPivot('user_id')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_graduate', 'response_id', 'user_id')->withPivot('graduate_id')->withTimestamps();
    }

}

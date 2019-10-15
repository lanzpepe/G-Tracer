<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'response_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'response_id');
    }
}

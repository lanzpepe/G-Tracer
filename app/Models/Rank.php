<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $guarded = [];

    public function achievement()
    {
        return $this->hasOne(Achievement::class);
    }
}

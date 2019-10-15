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
}

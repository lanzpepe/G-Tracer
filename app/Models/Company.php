<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'company_id';
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_id')->as('employment')->withPivot(['job_position', 'date_employed'])->withTimestamps();
    }
}

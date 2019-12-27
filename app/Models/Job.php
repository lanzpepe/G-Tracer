<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_job', 'job_id', 'course_id')->withTimestamps();
    }
}

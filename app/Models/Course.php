<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function schools()
    {
        return $this->belongsToMany(School::class, 'course_school', 'course_id', 'school_id')->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_course', 'course_id', 'dept_id')->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'course_job', 'course_id', 'job_id')->withTimestamps();
    }
}

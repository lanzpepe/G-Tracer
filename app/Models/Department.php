<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_department', 'dept_id', 'admin_id')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'department_course', 'dept_id', 'course_id')->withTimestamps();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_department', 'dept_id', 'school_id')->withTimestamps();
    }
}

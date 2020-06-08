<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_school', 'school_id', 'admin_id')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_school', 'school_id', 'course_id')->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'school_department', 'school_id', 'dept_id')->withTimestamps();
    }
}

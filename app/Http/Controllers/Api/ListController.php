<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Company;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Job;
use App\Models\Reward;
use App\Models\School;
use App\Models\SchoolYear;

class ListController extends Controller
{
    public function genders()
    {
        $genders = Gender::orderByDesc('name')->get();

        return response()->json(compact('genders'));
    }

    public function schools()
    {
        $schools = School::orderBy('name')->get();

        return response()->json(compact('schools'));
    }

    public function schoolDepartments($schoolId)
    {
        $departments = Department::whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->get();

        return response()->json(compact('departments'));
    }

    public function courseDepartment($courseId, $schoolId)
    {
        $department = Department::whereHas('courses', function ($query) use ($courseId) {
            return $query->where('id', $courseId);
        })->whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->first();

        return response()->json(compact('department'));
    }

    public function schoolCourses($schoolId)
    {
        $courses = Course::whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->orderBy('name')->get();

        return response()->json(compact('courses'));
    }

    public function deptCourses($deptId, $schoolId)
    {
        $courses = Course::whereHas('departments', function ($query) use ($deptId) {
            return $query->where('id', $deptId);
        })->whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->orderBy('name')->get();

        return response()->json(compact('courses'));
    }

    public function schoolYears()
    {
        $school_years = SchoolYear::orderByDesc('year')->get();

        return response()->json(compact('school_years'));
    }

    public function batches()
    {
        $batches = Batch::all();

        return response()->json(compact('batches'));
    }

    public function jobs($courseName)
    {
        $course = Course::where('name', rawurldecode($courseName))->first();
        $jobs = Job::whereHas('courses', function ($query) use ($course) {
            return $query->where('id', $course->id);
        })->get();

        return response()->json(compact('jobs'));
    }

    public function companies()
    {
        $companies = Company::all()->unique('name')->values()->all();

        return response()->json(compact('companies'));
    }

    public function rewards()
    {
        $rewards = Reward::with(['admins.departments'])->whereHas('admins')->get();

        return response()->json(compact('rewards'));
    }
}

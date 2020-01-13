<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\School;

class RegisterController extends Controller
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

    public function courses($schoolName)
    {
        $school = School::where('name', str_replace('+', ' ', $schoolName))->first();
        $courses = Course::whereHas('schools', function ($query) use ($school) {
            return $query->where('id', $school->id);
        })->get();

        return response()->json(compact('courses'));
    }

    public function department($courseName, $schoolName)
    {
        $course = Course::where('name', str_replace('+', ' ', $courseName))->first();
        $school = School::where('name', str_replace('+', ' ', $schoolName))->first();
        $department = Department::whereHas('courses', function ($query) use ($course) {
            return $query->where('id', $course->id);
        })->whereHas('schools', function ($query) use ($school) {
            return $query->where('id', $school->id);
        })->first();

        return response()->json(compact('department'));
    }

    public function schoolYears()
    {
        $school_years = AcademicYear::orderByDesc('school_year')->get();

        return response()->json(compact('school_years'));
    }

    public function batches()
    {
        $batches = Batch::orderBy('name')->get();

        return response()->json(compact('batches'));
    }
}

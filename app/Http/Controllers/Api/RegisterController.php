<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Company;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Graduate;
use App\Models\Job;
use App\Models\School;
use Illuminate\Http\Request;

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
        $school = School::where('name', rawurldecode($schoolName))->firstOrFail();
        $courses = Course::whereHas('schools', function ($query) use ($school) {
            return $query->where('id', $school->id);
        })->get();

        return response()->json(compact('courses'));
    }

    public function department($courseName, $schoolName)
    {
        $course = Course::where('name', rawurldecode($courseName))->firstOrFail();
        $school = School::where('name', rawurldecode($schoolName))->firstOrFail();
        $department = Department::whereHas('courses', function ($query) use ($course) {
            return $query->where('id', $course->id);
        })->whereHas('schools', function ($query) use ($school) {
            return $query->where('id', $school->id);
        })->firstOrFail();

        return response()->json(compact('department'));
    }

    public function academicYears()
    {
        $school_years = AcademicYear::orderByDesc('school_year')->get();

        return response()->json(compact('school_years'));
    }

    public function batches($sy)
    {
        $batches = AcademicYear::where('school_year', $sy)->firstOrFail();

        return response()->json(compact('batches'));
    }

    public function jobs($courseName)
    {
        $course = Course::where('name', rawurldecode($courseName))->firstOrFail();
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

    public function verify(Request $request)
    {
        $graduate = Graduate::where('last_name', $request->lastName)
                    ->where('first_name', $request->firstName)
                    ->where('middle_name', $request->middleName)
                    ->where('gender', $request->gender)
                    ->where('degree', $request->degree)
                    ->where('major', $request->major)
                    ->where('department', $request->department)
                    ->where('school', $request->school)
                    ->where('school_year', $request->schoolYear)
                    ->where('batch', $request->batch)->first();

        if ($graduate) {
            return response()->json([
                'message' => 'Verification success. You are a graduate from this batch.'
            ]);
        }

        return response()->json([
            'message' => 'Verification failed. You are not a graduate from this batch.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Company;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Graduate;
use App\Models\Job;
use App\Models\LinkedInProfile;
use App\Models\School;
use App\Models\Year;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use StaticTrait;

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

    public function courses($id)
    {
        $courses = Course::whereHas('schools', function ($query) use ($id) {
            return $query->where('id', $id);
        })->get();

        return response()->json(compact('courses'));
    }

    public function department($courseId, $schoolId)
    {
        $department = Department::whereHas('courses', function ($query) use ($courseId) {
            return $query->where('id', $courseId);
        })->whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->first();

        return response()->json(compact('department'));
    }

    public function schoolYears()
    {
        $school_years = Year::orderByDesc('year')->get();

        return response()->json(compact('school_years'));
    }

    public function batches()
    {
        $batches = Batch::all();

        return response()->json(compact('batches'));
    }

    public function linkedin(Request $request)
    {
        $profile = LinkedInProfile::where('last_name', $request->lastName)
                    ->where('first_name', $request->firstName)
                    ->first();

        return response()->json(compact('profile'));
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
                    ->whereHas('academic', function ($query) use ($request) {
                        return $query->where('degree', $request->degree)
                                ->where('major', $request->major)
                                ->where('department', $request->department)
                                ->where('school', $request->school)
                                ->where('year', $request->schoolYear)
                                ->where('batch', $request->batch);
                    })->first();

        if ($graduate) {
            return response()->json([
                'message' => 'Verification success. You are a graduate from this batch.'
            ]);
        }

        return response()->json([
            'message' => 'Verification failed. You are not a graduate from this batch.'
        ], 404);
    }
}

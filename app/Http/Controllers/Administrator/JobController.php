<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Course;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function jobs(Request $request)
    {
        $admin = AdminController::admin();
        $courses = Course::all();
        $jobs = Job::paginate(10);
        $page = $request->page;

        return view('administrator.related_job', compact('admin', 'courses', 'jobs', 'page'));
    }

    public function addJob(Request $request)
    {
        /* $validated = $request->validated();

        if ($validated) {
            $exploded = explode(' - ', $request->course);
            $course = Course::where('name', $exploded[0])->where('major', $exploded[1])->first();
            $job = Job::where('name', $request->jobName)->first();

            if ($job) {
                $result = DB::table('course_job')->where('course_id', $course->id)->where('job_id', $job->id)->first();

                if ($result) {
                    return back()->withInput()->withErrors(['jobName' => "Job already exists in that particular course."]);
                }
                else {
                    $j = Job::find($job->id);
                    $j->courses()->attach($course->id);

                    return back()->with('success', "Job added successfully.");
                }
            }
            else {
                $j = new Job();
                $j->id = Str::random();
                $j->name = strtoupper($request->jobName);
                $j->save();
                $j->courses()->attach($course->id);

                return back()->with('success', "Job added successfully.");
            }
        }
        else {
            return back()->withErrors($validated);
        } */

        $exploded = explode(',', $request->course);

        $courses = [];

        foreach ($exploded as $course) {
            $c = explode(' - ', $course);
            array_push($courses, $c);
        }

        dd($courses);
    }

    public function markJob($jobName)
    {
        $job = Job::where('name', $jobName)->first();

        return response()->json(compact('job'));
    }

    public function removeJob($job, $course, $major)
    {
        $course = Course::where('name', $course)->where('major', $major)->first();
        $job = Job::where('name', $job)->first();

        if ($job) {
            $job->courses()->detach($course->id);
        }

        return back()->with('success', "Job removed succesfully.");
    }
}

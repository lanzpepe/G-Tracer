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

    public function addJob(StoreJobRequest $request)
    {
        $data['courses'] = [];
        $validated = $request->validated();

        if ($validated) {
            $explode = explode(',', $request->course);

            foreach ($explode as $row) {
                $course = explode(' - ', $row);
                array_push($data['courses'], $course);
            }

            for ($row = 0; $row < count($data['courses']); $row++) {
                $course = Course::where('name', $data['courses'][$row][0])->where('major', $data['courses'][$row][1])->first();
                $job = Job::where('name', $request->job)->first();

                if ($job) {
                    $result = DB::table('course_job')->where('course_id', $course->id)->where('job_id', $job->id)->first();

                    if ($result) {
                        return back()->withInput()->withErrors(['job' => "Job already exists in that particular course."]);
                    }
                    else {
                        $j = Job::find($job->id);
                        $j->courses()->attach($course->id);
                    }
                }
                else {
                    $j = new Job();
                    $j->id = Str::random();
                    $j->name = strtoupper($request->job);
                    $j->save();
                    $j->courses()->attach($course->id);
                }
            }

            return back()->with('success', "Job added successfully.");
        }
        else {
            return back()->withErrors($validated);
        }
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

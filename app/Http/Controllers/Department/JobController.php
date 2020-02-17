<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Job;
use App\Traits\StaticTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{
    use StaticTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::authUser();
        $courses = Course::orderBy('name')->get();
        $jobs = Job::orderBy('name')->paginate(10);
        $page = request()->page;

        return view('department.related_job', compact('admin', 'courses', 'jobs', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        $courses['course'] = [];
        $data = $request->validated();
        $explode = explode(',', $data['course']);

        foreach ($explode as $row) {
            $course = explode(' - ', $row);
            array_push($courses['course'], $course);
        }

        for ($row = 0; $row < count($courses['course']); $row++) {
            $course = Course::where('name', $courses['course'][$row][0])->where('major', $courses['course'][$row][1])->first();
            $job = Job::where('name', $data['job'])->first();

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
                $j = Job::create([
                    'id' => Str::random(),
                    'name' => $this->capitalize($data['job'])
                ]);
                $j->courses()->attach($course->id);
            }
        }

        return back()->with('success', "Job added successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::with('courses')->find($id);

        return response()->json(compact('job'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = explode('+', $id);
        $job = Job::find($data[0]);

        if ($job) {
            $job->courses()->detach($data[1]);
        }

        return back()->with('success', "Job removed succesfully.");
    }
}
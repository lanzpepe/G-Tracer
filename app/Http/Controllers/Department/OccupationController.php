<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOccupationRequest;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Occupation;
use App\Traits\StaticTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OccupationController extends Controller
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
        $courses = Course::whereHas('departments', function ($query) use ($admin) {
            return $query->where('id', $admin->departments->first()->id);
        })->orderBy('name')->get();
        $jobs = Occupation::whereHas('courses')->orderBy('name')->paginate(10);

        return view('department.related_job', compact('admin', 'courses', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOccupationRequest $request)
    {
        $data = $request->validated();
        $codes = explode(',', $data['course']);

        foreach ($codes as $code) {
            $course = Course::where('code', $code)->first();
            $job = Occupation::where('name', $data['job'])->first();

            if ($job) {
                $result = DB::table('course_job')->where('course_id', $course->id)->where('job_id', $job->id)->first();

                if ($result) {
                    return back()->withInput()->withErrors(['job' => "Job already exists in that particular course."]);
                }
                else {
                    $j = Occupation::find($job->id);
                    $j->courses()->attach($course->id);
                }
            }
            else {
                $j = Occupation::create([
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
        $job = Occupation::with('courses')->find($id);

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
        $job = Occupation::find($data[0]);

        if ($job) {
            $job->courses()->detach($data[1]);
        }

        return back()->with('success', "Job removed succesfully.");
    }
}

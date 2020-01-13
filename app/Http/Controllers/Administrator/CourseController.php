<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use App\Models\School;
use App\Traits\StaticTrait;
use Illuminate\Support\Str;

class CourseController extends Controller
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
        $depts = Department::orderBy('name')->get();
        $schools = School::orderBy('name')->get();
        $courses = Course::orderBy('name')->paginate(10);
        $page = request()->page;

        return view('administrator.course', compact('admin', 'courses', 'depts', 'schools', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $major = $request->filled('major') ? $data['major'] : "None";
        $school = School::where('name', $data['school'])->first();
        $dept = Department::where('name', $data['dept'])->first();

        if ($request->btnCourse == 'added') {
            $course = Course::create([
                'id' => Str::random(),
                'name' => $this->capitalize($data['course']),
                'major' => $this->capitalize($major),
                'code' => $data['code']
            ]);

            $course->departments()->attach($dept->id);
            $course->schools()->attach($school->id);

            return back()->with('success', "Course {$request->btnCourse} successfully.");
        }
        else {
            $result = Course::whereHas('departments', function ($query) use ($dept) {
                return $query->where('id', $dept->id);
            })->where('code', $data['code'])->first();

            $course = Course::updateOrCreate([
                'id' => $result->id
            ], [
                'name' => $this->capitalize($data['course']),
                'major' => $this->capitalize($major),
                'code' => $data['code']
            ]);

            $course->departments()->sync($dept->id);
            $course->schools()->sync($school->id);

            return back()->with('success', "Course added successfully.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with(['departments', 'schools'])->find($id);

        return response()->json(compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::with(['departments', 'schools'])->find($id);

        return response()->json(compact('course'));
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
        $course = Course::find($data[0]);

        if ($course) {
            $course->departments()->detach($data[1]);
            $course->schools()->detach($data[2]);
        }

        return back()->with('success', "Course removed successfully.");
    }
}

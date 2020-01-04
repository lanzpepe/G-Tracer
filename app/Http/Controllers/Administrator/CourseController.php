<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
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
        $school = School::where('name', $data['school'])->first();
        $dept = Department::where('name', $data['dept'])->first();
        $major = $request->filled('major') ? $data['major'] : "None";
        $course = Course::where('name', $data['course'])->where('major', $major)->first();

        if ($request->btnCourse == 'added') {
            if (!$course) {
                $newCourse = Course::create([
                    'id' => Str::random(),
                    'name' => User::formatString($data['course']),
                    'major' => $request->filled('major') ? User::formatString($major) : "NONE"
                ]);
                $newCourse->departments()->attach($dept->id);
                $newCourse->schools()->attach($school->id);

                return back()->with('success', "Course {$request->btnCourse} successfully.");
            }
            else {
                $result = DB::table('course_school')->where('course_id', $course->id)
                            ->where('school_id', $school->id)->first();

                if (!$result) {
                    $createCourse = Course::find($course->id);
                    $createCourse->departments()->attach($dept->id);
                    $createCourse->schools()->attach($school->id);

                    return back()->with('success', "Course added successfully.");
                }
                else {
                    return back()->withInput()->withErrors(['course' => "Course already exists."]);
                }
            }
        }
        else {
            if (!$course) {
                $createCourse = Department::find($dept->id)->courses->first();
                $createCourse->name = User::formatString($data['course']);
                $createCourse->major = User::formatString($data['major']);
                $createCourse->save();

                return back()->with(['success' => "Course {$request->btnCourse} successfully."]);
            }
            else {
                $result = DB::table('department_course')->where('dept_id', $dept->id)
                        ->where('course_id', $course->id)->first();

                if (!$result) {
                    $createCourse = Course::find($course->id);
                    $createCourse->departments()->sync($dept->id);
                    $createCourse->schools()->sync($school->id);

                    return back()->with('success', "Course added successfully.");
                }
                else {
                    return back()->withInput()->withErrors(['course' => "Course already exists."]);
                }
            }
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

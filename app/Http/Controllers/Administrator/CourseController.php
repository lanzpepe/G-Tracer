<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Department;
use App\Models\Course;
use App\Models\School;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function courses(Request $request)
    {
        $admin = AdminController::admin();
        $depts = Department::orderBy('name')->get();
        $schools = School::orderBy('name')->get();
        $courses = Course::orderBy('name')->paginate(10);
        $page = $request->page;

        return view('administrator.course', compact('admin', 'courses', 'depts', 'schools', 'page'));
    }

    public function addCourse(StoreCourseRequest $request)
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
                    'name' => AdminController::formatString($data['course']),
                    'major' => $request->filled('major') ? AdminController::formatString($major) : "NONE"
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
                $createCourse->name = AdminController::formatString($data['course']);
                $createCourse->major = AdminController::formatString($data['major']);
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

    public function markCourse($course, $major)
    {
        $course = Course::where('name', $course)->where('major', $major)->first();

        return response()->json(compact('course'));
    }

    public function removeCourse($course, $major, $department, $school) {
        $course = Course::where('name', $course)->where('major', $major)->first();
        $deptId = Department::where('name', $department)->first()->id;
        $schoolId = School::where('name', $school)->first()->id;

        if ($course) {
            $course->departments()->detach($deptId);
            $course->schools()->detach($schoolId);
        }

        return back()->with('success', "Course removed successfully.");
    }
}

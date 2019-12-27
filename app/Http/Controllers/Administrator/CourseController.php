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
        $depts = Department::all();
        $schools = School::all();
        $courses = Course::orderBy('name')->paginate(10);
        $page = $request->page;

        return view('administrator.course', compact('admin', 'courses', 'depts', 'schools', 'page'));
    }

    public function addCourse(StoreCourseRequest $request)
    {
        $validated = $request->validated();
        $schoolId = School::where('name', $request->school)->first()->id;
        $deptId = Department::where('name', $request->department)->first()->id;
        $major = $request->filled('major') ? $request->major : "NONE";

        if ($validated) {
            $course = Course::where('name', $request->course)->where('major', $major)->first();

            if ($request->btnCourse === 'add') {
                if (!$course) {
                    $cs = new Course();
                    $cs->id = Str::random();
                    $cs->name = strtoupper($request->course);
                    $cs->major = $request->filled('major') ? strtoupper($major) : "NONE";
                    $cs->save();
                    $cs->departments()->attach($deptId);
                    $cs->schools()->attach($schoolId);

                    return back()->with('success', "Course added successfully.");
                }
                else {
                    $result = DB::table('course_school')->where('course_id', $course->id)->where('school_id', $schoolId)->first();

                    if (!$result) {
                        $cs = Course::find($course->id);
                        $cs->departments()->attach($deptId);
                        $cs->schools()->attach($schoolId);

                        return back()->with('success', "Course added successfully.");
                    }
                    else {
                        return back()->withInput()->withErrors(['courseName' => "Course already exists."]);
                    }
                }
            }
            else {
                if (!$course) {
                    $cs = Department::find($deptId)->courses->first();
                    $cs->name = strtoupper($request->course);
                    $cs->major = strtoupper($request->major);
                    $cs->save();

                    return back()->with(['success' => "Course name modified successfully."]);
                }
                else {
                    $result = DB::table('department_course')->where('dept_id', $deptId)
                            ->where('course_id', $course->id)->first();

                    if (!$result) {
                        $cs = Course::find($course->id);
                        $cs->departments()->sync($deptId);
                        $cs->schools()->sync($schoolId);

                        return back()->with('success', "Course added successfully.");
                    }
                    else {
                        return back()->withInput()->withErrors(['courseName' => "Course already exists."]);
                    }
                }
            }
        }
        else {
            return back()->withInput()->withErrors($validated);
        }
    }

    public function searchCourse(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::where('name', 'LIKE', '%'. $request->course . '%')->select('name')->groupBy('name')->get();
            $output = '';

            if (count($data) > 0) {
                foreach ($data as $row) {
                    $output .= '<div class="item" data-value="' . $row->name . '">' . $row->name . '</div>';
                }
            }

            return $output;
        }
    }

    public function searchMajor(Request $request) {
        $output = "";

        if ($request->ajax()) {
            $data = Course::where('major', 'LIKE', '%' . $request->major . '%')->select('major')->groupBy('major')->get();

            if (count($data) > 0) {
                $output = '<div class="list-group">';
                foreach ($data as $row) {
                    $output .= '<a href="javascript:void(0)" class="list-group-item list-group-item-action h6">' . $row->major . '</a>';
                }
                $output .= '</div>';
            }

            return $output;
        }
    }

    public function markCourse($course, $major)
    {
        $course = Course::with(['departments', 'schools'])->where('name', $course)->where('major', $major)->first();

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

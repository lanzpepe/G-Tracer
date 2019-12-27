<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Department;
use App\Models\School;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function fetch(Request $request)
    {
        $school = School::where('name', $request->get('value'))->first();
        $data = $school->departments()->get();
        $option = '<option value="" selected>-- SELECT DEPARTMENT --</option>';

        foreach ($data as $row) {
            $option .= '<option value="' . $row->name . '">' . $row->name . '</option>';
        }

        return $option;
    }

    public function departments(Request $request)
    {
        $admin = AdminController::admin();
        $schools = School::all();
        $depts = Department::orderBy('name')->paginate(10);
        $page = $request->page;

        return view('administrator.department', compact('admin', 'depts', 'schools', 'page'));
    }

    public function addDepartment(StoreDepartmentRequest $request)
    {
        $school = School::where('name', $request->school)->first();
        $department = Department::where('name', $request->department)->first();
        $validated = $request->validated();

        if ($validated) {
            if ($department) {
                $result = DB::table('school_department')->where('dept_id', $department->id)->where('school_id', $school->id)->first();

                if ($result) {
                    return back()->withErrors(['department' => "Department already exists."]);
                }
                else {
                    $dept = Department::find($department->id);
                    $dept->schools()->attach($school->id);

                    return back()->with('success', "Department added successfully.");
                }
            }
            else {
                $dept = new Department();
                $dept->id = Str::random();
                $dept->name = strtoupper($request->department);
                $dept->save();
                $dept->schools()->attach($school->id);

                return back()->with('success', "Department added successfully.");
            }
        }
        else {
            return back()->withInput()->withErrors($validated);
        }
    }

    public function markDepartment($department) {
        $dept = Department::with('schools')->where('name', $department)->first();

        return response()->json(compact('dept'));
    }

    public function removeDepartment($department, $school) {
        $department = Department::where('name', $department)->first();
        $schoolId = School::where('name', $school)->first()->id;

        if ($department) {
            $department->schools()->detach($schoolId);
        }

        return back()->with('success', "Department removed succesfully.");
    }
}

<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::authUser();
        $schools = School::orderBy('name')->get();
        $depts = Department::orderBy('name')->paginate(15);
        $page = request()->page;

        return view('administrator.department', compact('admin', 'depts', 'schools', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();
        $school = School::where('name', $data['school'])->first();
        $department = Department::where('name', $data['dept'])->first();

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
            $dept = Department::create([
                'id' => Str::random(),
                'name' => User::formatString($data['dept'])
            ]);
            $dept->schools()->attach($school->id);

            return back()->with('success', "Department added successfully.");
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
        $dept = Department::with('schools')->find($id);

        return response()->json(compact('dept'));
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
        $department = Department::find($data[0]);

        if ($department) {
            $department->schools()->detach($data[1]);
        }

        return back()->with('success', "Department removed succesfully.");
    }

    public function fetch(Request $request)
    {
        $school = School::where('name', $request->get('value'))->first();
        $data = $school->departments()->get();
        $option = '<option value="" selected>-- Select Department --</option>';

        foreach ($data as $row) {
            $option .= '<option value="' . $row->name . '">' . $row->name . '</option>';
        }

        return $option;
    }
}

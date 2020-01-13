<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\School;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
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
        $deptName = $this->capitalize($data['dept']);
        $schoolName = $this->capitalize($data['school']);
        $school = School::where('name', $schoolName)->first();
        $department = Department::where('name', $deptName)->first();
        $imagePath = null;

        if ($request->has('logo')) {
            $imagePath = $request->file('logo')->storeAs('departments/' . $schoolName, $deptName,  'public');
        }

        $result = Department::whereHas('schools', function ($query) use ($school) {
            return $query->where('id', $school->id);
        })->where('id', $department->id)->first();

        if ($result) {
            return back()->withErrors(['department' => "Department already exists."]);
        }
        else {
            $dept = Department::updateOrCreate([
                'id' => $department ? $department->id : Str::random()
            ], [
                'name' => $deptName,
                'logo' => $imagePath
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

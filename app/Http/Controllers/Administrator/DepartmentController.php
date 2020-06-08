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
        $imagePath = null; $data = $request->validated();
        $schoolName = $this->capitalize($data['school']);
        $deptName = $this->capitalize($data['dept']);
        $school = School::where('name', $schoolName)->first();
        $dept = Department::where('name', $deptName)->first();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $location = "logos/department/{$schoolName}";
            $imagePath = rawurlencode($file->storeAs($location, "{$deptName}.{$file->getClientOriginalExtension()}", 'public'));
        }

        if (!$dept) {
            $department = Department::create([
                'id' => Str::random(),
                'name' => $deptName,
                'logo' => $imagePath
            ]);

            $department->schools()->attach($school->id);

            return back()->with('success', "Department added successfully.");
        }
        else {
            $result = Department::whereHas('schools', function ($query) use ($school) {
                return $query->where('id', $school->id);
            })->where('id', $dept->id)->first();

            if ($result) {
                return back()->withInput()->withErrors(['department' => "Department already exists."]);
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
        $option = "<option value='' selected>-- Select Department --</option>";

        foreach ($data as $row) {
            $option .= "<option value='{$row->name}'{$row->name}</option>";
        }

        return $option;
    }
}

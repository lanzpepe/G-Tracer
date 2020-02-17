<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraduateRequest;
use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Graduate;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GraduateController extends Controller
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
        $dept = Department::find($admin->departments->first()->id);
        $courses = Course::whereHas('departments', function ($query) use ($dept) {
            return $query->where('id', $dept->id);
        })->get();
        $genders = Gender::all();
        $graduates = Graduate::where('department', $admin->departments->first()->name)
                    ->where('school', $admin->schools->first()->name)
                    ->orderBy('last_name')->paginate(10);
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();

        return view('department.graduates', compact('admin', 'courses',
                'genders', 'graduates', 'schoolYears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGraduateRequest $request)
    {
        $data = $request->validated();
        $imagePath = null;

        if ($request->has('image')) {
            $imagePath = $request->file('image')->storeAs("graduates/{$data['sy']}/{$data['batch']}", "{$data['lastname']}, {$data['firstname']}", 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->orientate();
            $image->save();
        }

        Graduate::updateOrCreate([
            'graduate_id' => $request->btnGraduate == 'added' ? Str::random() : $request->temp
        ],[
            'last_name' => $this->capitalize($data['lastname']),
            'first_name' => $this->capitalize($data['firstname']),
            'middle_name' => $this->capitalize($data['midname']),
            'gender' => $this->capitalize($data['gender']),
            'code' => Course::where('name', $data['course'])->first()->code,
            'degree' => $this->capitalize($data['course']),
            'major' => $this->capitalize($data['major']),
            'department' => $this->capitalize($data['dept']),
            'school' => $this->capitalize($data['school']),
            'school_year' => $data['sy'],
            'batch' => $this->capitalize($data['batch']),
            'image_uri' => $imagePath
        ]);

        return back()->with('success', "Graduate {$request->btnGraduate} successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $graduate = Graduate::find($id);

        return response()->json(compact('graduate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $graduate = Graduate::find($id);

        return response()->json(compact('graduate'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $graduate = Graduate::find($id);

        if ($graduate) {
            $graduate->delete();
        }

        return back()->with('success', 'Graduate removed successfully.');
    }

    public function fetch(Request $request)
    {
        $sy = AcademicYear::where('school_year', $request->get('value'))->first();
        $option = "<option value='' selected>-- Select Batch --</option>";
        $option .= "<option value='{$sy->first_batch}'>{$sy->first_batch}</option>";
        $option .= "<option value='{$sy->second_batch}'>{$sy->second_batch}</option>";

        return $option;
    }
}

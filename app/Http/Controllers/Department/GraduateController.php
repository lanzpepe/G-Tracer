<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraduateRequest;
use App\Models\Admin;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Gender;
use App\Models\Graduate;
use App\Models\Year;
use App\Traits\StaticTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $genders = Gender::all();
        $batches = Batch::all();
        $years = Year::orderByDesc('year')->get();
        $courses = Course::whereHas('departments', function ($query) use ($admin) {
            $query->where('id', $admin->departments->first()->id);
        })->get();
        $graduates = Graduate::whereHas('academic', function ($query) use ($admin) {
            return $query->where('department', $admin->departments->first()->name)
                        ->where('school', $admin->schools->first()->name);
        })->get()->sortByDesc('academic.year');

        return view('department.graduates', compact('admin', 'batches', 'courses',
                'genders', 'graduates', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGraduateRequest $request)
    {
        $imagePath = null; $adminId = Auth::user()->admin_id;
        $data = $request->validated();
        $course = Course::where('name', $data['course'])->where('major', $data['major'])->first();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $location = "files/{$adminId}/images/graduates/{$course->code}/{$data['batch']}/{$data['sy']}";

            if (Storage::makeDirectory("public/{$location}")) {
                $imagePath = $request->file('image')->storeAs($location, $image->getClientOriginalName(), 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->orientate();
                $image->save();
            }
        }

        $graduate = Graduate::updateOrCreate([
            'graduate_id' => $request->btnGraduate == 'added' ? Str::random() : $request->temp
        ],[
            'last_name' => $this->capitalize($data['lastname']),
            'first_name' => $this->capitalize($data['firstname']),
            'middle_name' => $this->capitalize($data['midname']),
            'gender' => $this->capitalize($data['gender']),
            'image_uri' => $imagePath
        ]);
        $graduate->contacts()->create([
            'contact_id' => Str::random(),
            'address' => $this->capitalize($data['address']),
            'latitude' => $this->getLatLng($data['address'])['lat'],
            'longitude' => $this->getLatLng($data['address'])['lng'],
        ]);
        $graduate->academic()->create([
            'academic_id' => Str::random(),
            'code' => $course->code,
            'degree' => $this->capitalize($data['course']),
            'major' => $this->capitalize($data['major']),
            'department' => $this->capitalize($data['dept']),
            'school' => $this->capitalize($data['school']),
            'year' => $data['sy'],
            'batch' => $this->capitalize($data['batch'])
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
        $graduate = Graduate::with('academic')->find($id);

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
        $graduate = Graduate::with(['academic', 'contacts'])->find($id);

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
}

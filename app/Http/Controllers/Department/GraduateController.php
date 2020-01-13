<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraduateRequest;
use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Graduate;
use App\Traits\StaticTrait;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GraduateController extends Controller
{
    use StaticTrait;

    public function graduates()
    {
        $admin = Admin::authUser();
        $dept = Department::find($admin->departments->first()->id);
        $courses = Course::whereHas('departments', function ($query) use ($dept) {
            return $query->where('id', $dept->id);
        })->get();
        $genders = Gender::all();
        $graduates = Graduate::where('department', $admin->departments->first()->name)
                    ->where('school', $admin->schools->first()->name)
                    ->orderBy('last_name')->paginate(20);
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();
        $batches = Batch::all();

        return view('department.graduates', compact('admin', 'batches',
            'courses', 'genders', 'graduates', 'schoolYears'));
    }

    public function add(StoreGraduateRequest $request)
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

    public function mark($graduateId)
    {
        $graduate = Graduate::find($graduateId);

        return response()->json(compact('graduate'));
    }

    public function remove($graduateId)
    {
        $graduate = Graduate::find($graduateId);

        if ($graduate) {
            $graduate->delete();
        }

        return back()->with('success', 'Graduate removed successfully.');
    }
}

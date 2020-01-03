<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraduateRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Graduate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GraduateController extends Controller
{
    public function graduates()
    {
        $admin = DepartmentController::department();
        $dept = Department::find($admin->departments->first()->id);
        $courses = Course::join('department_course', 'courses.id', '=', 'course_id')
                    ->join('departments', 'department_course.dept_id', '=', 'departments.id')
                    ->where('departments.id', $dept->id)->select('courses.*')->get();
        $genders = Gender::orderByDesc('name')->get();
        $graduates = Graduate::where('department', $admin->departments->first()->name)
                    ->where('school', $admin->schools->first()->name)
                    ->orderBy('last_name')->paginate(20);
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();
        $batches = Batch::orderBy('name')->get();

        return view('department.graduates', compact('admin', 'batches',
            'courses', 'genders', 'graduates', 'schoolYears'));
    }

    public function addGraduate(StoreGraduateRequest $request)
    {
        $data = $request->validated();
        $graduateId = Str::random();
        $imagePath = null;

        if ($request->has('image')) {
            $imagePath = $request->file('image')->storeAs("graduates/{$data['sy']}/{$data['batch']}", "{$data['lastname']}, {$data['firstname']}", 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->orientate();
            $image->save();
        }

        Graduate::updateOrCreate([
            'last_name' => DepartmentController::formatString($data['lastname']),
            'first_name' => DepartmentController::formatString($data['firstname']),
            'middle_name' => DepartmentController::formatString($data['midname'])
        ], [
            'graduate_id' => $graduateId,
            'gender' => DepartmentController::formatString($data['gender']),
            'degree' => DepartmentController::formatString($data['course']),
            'major' => DepartmentController::formatString($data['major']),
            'department' => DepartmentController::formatString($data['dept']),
            'school' => DepartmentController::formatString($data['school']),
            'school_year' => $data['sy'],
            'batch' => DepartmentController::formatString($data['batch']),
            'image_uri' => $imagePath
        ]);

        return back()->with('success', "Graduate {$request->btnGraduate} successfully.");
    }

    public function markGraduate($graduateId)
    {
        $graduate = Graduate::find($graduateId);

        return Response::json(compact('graduate'), 200);
    }
}

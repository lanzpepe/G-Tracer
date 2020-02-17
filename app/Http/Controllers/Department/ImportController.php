<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportRequest;
use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Course;
use App\Models\CsvFile;
use App\Models\Graduate;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportController extends Controller
{
    use StaticTrait;

    public function import()
    {
        CsvFile::truncate();
        $admin = Admin::authUser();
        $school = $admin->schools->first();
        $department = $admin->departments->first();
        $courses = Course::whereHas('schools', function ($query) use ($school) {
            return $query->where('name', $school->name);
        })->whereHas('departments', function ($query) use ($department) {
            return $query->where('name', $department->name);
        })->orderBy('name')->get();
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();

        return view('department.import', compact('admin', 'courses', 'schoolYears'));
    }

    public function parseImport(StoreImportRequest $request)
    {
        $data = $request->validated();

        $admin = Admin::authUser();
        $school = $admin->schools->first();
        $department = $admin->departments->first();
        $courses = Course::whereHas('schools', function ($query) use ($school) {
            return $query->where('name', $school->name);
        })->whereHas('departments', function ($query) use ($department) {
            return $query->where('name', $department->name);
        })->orderBy('name')->get();
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();
        $course = $this->capitalize($data['course']);
        $major = $this->capitalize($data['major']);
        $schoolYear = $this->capitalize($data['sy']);
        $batch = $this->capitalize($data['batch']);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $file = Reader::createFromPath($path, 'r')->setHeaderOffset(0);
            $csvData = (new Statement)->process($file);

            $csvFile = CsvFile::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'has_header' => $request->has('header'),
                'data' => json_encode($csvData)
            ]);

            return view('department.fields', compact('admin', 'schoolYears', 'batch',
                    'course', 'courses', 'major', 'csvFile', 'csvData', 'schoolYear'));
        }
        else
            return redirect()->route('import');
    }

    public function processImport(Request $request)
    {
        try {
            $fileId = Crypt::decrypt($request->data);
            $csvFile = CsvFile::find($fileId);
            $csvData = json_decode($csvFile->data, true);

            foreach ($csvData as $data) {
                $graduate = Graduate::where('last_name', $this->capitalize($data['Last Name']))
                            ->where('first_name', $this->capitalize($data['First Name']))
                            ->where('middle_name', substr($this->capitalize($data['M.I.']), 0, 1))
                            ->first();
                $course = Course::where('name', $request->course)->where('major', $request->major)->first();

                Graduate::updateOrCreate([
                    'last_name' => $this->capitalize($data['Last Name']),
                    'first_name' => $this->capitalize($data['First Name']),
                    'middle_name' => substr($this->capitalize($data['M.I.']), 0, 1)
                ], [
                    'graduate_id' => $graduate ? $graduate->graduate_id : Str::random(),
                    'gender' => $this->capitalize($data['Gender']),
                    'code' => $course->code,
                    'degree' => $this->capitalize($request->course),
                    'major' => $this->capitalize($request->major),
                    'department' => $this->capitalize($request->dept),
                    'school' => $this->capitalize($request->school),
                    'school_year' => $request->sy,
                    'batch' => $this->capitalize($request->batch),
                    'image_uri' => rawurlencode(
                        "files/" . Auth::user()->admin_id . "/graduates/{$course->code}/" .
                        "{$request->batch} {$request->sy}/{$data['Last Name']}, {$data['First Name']}.jpg"
                    )
                ]);
            }

            $csvFile->delete();

            return redirect()->route('graduates.index');

        } catch (DecryptException $e) {
            $e->getMessage();
        }
    }
}

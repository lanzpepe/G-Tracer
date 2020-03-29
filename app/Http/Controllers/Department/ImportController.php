<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportRequest;
use App\Models\Admin;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CsvFile;
use App\Models\Graduate;
use App\Models\LinkedInProfile;
use App\Models\Year;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
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
        $batches = Batch::all();
        $years = Year::orderByDesc('year')->get();
        $courses = Course::whereHas('schools', function ($query) use ($admin) {
            return $query->where('name', $admin->schools->first()->name);
        })->whereHas('departments', function ($query) use ($admin) {
            return $query->where('name', $admin->departments->first()->name);
        })->orderBy('name')->get();

        return view('department.import', compact('admin', 'batches', 'courses', 'years'));
    }

    public function parseGraduateData(StoreImportRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::authUser();
        $batches = Batch::all();
        $courses = Course::whereHas('schools', function ($query) use ($admin) {
            return $query->where('name', $admin->schools->first()->name);
        })->whereHas('departments', function ($query) use ($admin) {
            return $query->where('name', $admin->departments->first()->name);
        })->orderBy('name')->get();
        $years = Year::orderByDesc('year')->get();
        $course = Course::where('name', $data['course'])->where('major', $data['major'])->first();
        $year = $this->capitalize($data['sy']);
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

            return view('department.fields', compact('admin', 'batch', 'batches',
                    'course', 'courses', 'csvData', 'csvFile', 'year', 'years'));
        }

        return redirect()->route('import');
    }

    public function uploadGraduateData(Request $request)
    {
        try {
            $fileId = Crypt::decrypt($request->data);
            $csvFile = CsvFile::find($fileId);
            $csvData = json_decode($csvFile->data, true);

            foreach ($csvData as $data) {
                $course = Course::where('name', $request->course)->where('major', $request->major)->first();
                $graduate = Graduate::create([
                    'graduate_id' => Str::random(),
                    'last_name' => $this->capitalize($data['Last Name']),
                    'first_name' => $this->capitalize($data['First Name']),
                    'middle_name' => $this->capitalize($data['M.I.']),
                    'gender' => $this->capitalize($data['Gender']),
                    'image_uri' => null
                ]);
                $graduate->contacts()->create([
                    'contact_id' => Str::random(),
                    'address' => $this->capitalize($data['Address']),
                    'latitude' => $this->getLatLng($data['Address'])['lat'],
                    'longitude' => $this->getLatLng($data['Address'])['lng']
                ]);
                $graduate->academic()->create([
                    'academic_id' => Str::random(),
                    'code' => $course->code,
                    'degree' => $course->name,
                    'major' => $course->major,
                    'department' => $request->dept,
                    'school' => $request->school,
                    'year' => $request->sy,
                    'batch' => $request->batch
                ]);
            }

            $csvFile->delete();

            return redirect()->route('import')->with('success', 'Data uploaded successfully.');

        } catch (DecryptException $e) {
            echo($e->getMessage());
        }
    }

    public function parseLinkedInData(Request $request)
    {
        $admin = Admin::authUser();
        $batches = Batch::all();
        $years = Year::orderByDesc('year')->get();
        $courses = Course::whereHas('schools', function ($query) use ($admin) {
            return $query->where('name', $admin->schools->first()->name);
        })->whereHas('departments', function ($query) use ($admin) {
            return $query->where('name', $admin->departments->first()->name);
        })->orderBy('name')->get();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $file = Reader::createFromPath($path, 'r')->setHeaderOffset(0);
            $csvData = (new Statement)->process($file);

            $csvFile = CsvFile::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'has_header' => $request->has('header'),
                'data' => json_encode($csvData)
            ]);

            return view('department.fields_in', compact('admin', 'batches', 'courses',
                    'years', 'csvData', 'csvFile'));
        }

        return redirect()->route('import');
    }

    public function uploadLinkedInData(Request $request)
    {
        try {
            $csv = CsvFile::find(Crypt::decrypt($request->data));
            $csvData = json_decode($csv->data, true);

            foreach ($csvData as $data) {
                LinkedInProfile::create([
                    'id' => $data['id'],
                    'full_name' => $data['Full name'],
                    'profile_url' => $data['Profile url'],
                    'first_name' => $data['First name'],
                    'last_name' => $data['Last name'],
                    'avatar' => empty($data['Avatar']) ? null : $data['Avatar'],
                    'title' => empty($data['Title']) ? null : $data['Title'],
                    'company' => empty($data['Company']) ? null : $data['Company'],
                    'position' => empty($data['Position']) ? null : $data['Position']
                ]);
            }

            $csv->delete();

            return redirect()->route('import')->with('success', 'Data uploaded successfully.');

        } catch (DecryptException $e) {
            echo($e->getMessage());
        }
    }
}

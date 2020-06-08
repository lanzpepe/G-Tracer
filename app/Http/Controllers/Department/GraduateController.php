<?php

namespace App\Http\Controllers\Department;

use App\Events\GraduateAdded;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraduateRequest;
use App\Http\Requests\StoreImportRequest;
use App\Models\Admin;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CsvFile;
use App\Models\Gender;
use App\Models\Graduate;
use App\Models\SchoolYear;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use League\Csv\Reader;
use League\Csv\Statement;

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
        $years = SchoolYear::orderByDesc('year')->get();
        $courses = Course::whereHas('departments', function ($query) use ($admin) {
            $query->where('id', $admin->departments->first()->id);
        })->orderBy('name')->get();
        $graduates = Graduate::whereHas('academic', function ($query) use ($admin) {
            return $query->where('department', $admin->departments->first()->name)
                        ->where('school', $admin->schools->first()->name);
        })->orderBy('last_name')->paginate(10);

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
            $location = "files/{$adminId}/images/graduates/{$course->code}/{$data['sy']}/{$data['batch']}";

            if (Storage::makeDirectory("public/{$location}")) {
                $imagePath = $request->file('image')->storeAs($location, $image->getClientOriginalName(), 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->orientate();
                $image->resize(320, 320);
                $image->save();
                $imagePath = urlencode("storage/{$imagePath}");
            }
        }

        $graduate = Graduate::updateOrCreate([
            'graduate_id' => $request->btnGraduate == 'added' ? Str::uuid() : $request->temp
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
            'latitude' => 0.0,
            'longitude' => 0.0,
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

        event(new GraduateAdded($graduate));

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

    public function parse(StoreImportRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::authUser();
        $batches = Batch::all();
        $courses = Course::whereHas('schools', function ($query) use ($admin) {
            return $query->where('name', $admin->schools->first()->name);
        })->whereHas('departments', function ($query) use ($admin) {
            return $query->where('name', $admin->departments->first()->name);
        })->orderBy('name')->get();
        $years = SchoolYear::orderByDesc('year')->get();
        $course = Course::where('name', $data['_course'])->where('major', $data['_major'])->first();
        $year = $this->capitalize($data['_sy']);
        $batch = $this->capitalize($data['_batch']);

        if ($request->hasFile('_file')) {
            $path = $request->file('_file')->getRealPath();
            $file = Reader::createFromPath($path, 'r')->setHeaderOffset(0);
            $csvData = (new Statement)->process($file);

            $csvFile = CsvFile::create([
                'file_name' => $request->file('_file')->getClientOriginalName(),
                'has_header' => $request->has('header'),
                'data' => json_encode($csvData)
            ]);

            return view('department.fields', compact('admin', 'batch', 'batches',
                    'course', 'courses', 'csvData', 'csvFile', 'year', 'years'));
        }

        return redirect()->route('graduates.index');
    }

    public function upload(Request $request)
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
                    'latitude' => 0.0,
                    'longitude' => 0.0
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

                event(new GraduateAdded($graduate));
            }

            $csvFile->delete();

            return redirect()->route('graduates.index')->with('success', 'Data uploaded successfully.');

        } catch (DecryptException $e) {
            echo($e->getMessage());
        }
    }
}

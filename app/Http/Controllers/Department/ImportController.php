<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportRequest;
use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Batch;
use App\Models\CsvFile;
use App\Models\Graduate;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportController extends Controller
{
    public function import()
    {
        CsvFile::truncate();
        $admin = Admin::authUser();
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();
        $batches = Batch::orderBy('name')->get();

        return view('department.import', compact('admin', 'schoolYears', 'batches'));
    }

    public function parseImport(StoreImportRequest $request)
    {
        $data = $request->validated();

        $schoolYear = User::formatString($data['sy']);
        $batch = User::formatString($data['batch']);
        $schoolYears = AcademicYear::orderByDesc('school_year')->get();
        $batches = Batch::orderBy('name')->get();
        $admin = Admin::authUser();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $file = Reader::createFromPath($path, 'r')->setHeaderOffset(0);
            $csvData = (new Statement)->process($file);

            $csvFile = CsvFile::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'has_header' => $request->has('header'),
                'data' => json_encode($csvData)
            ]);

            return view('department.fields', compact('admin', 'schoolYears',
                    'batch', 'batches', 'csvFile', 'csvData', 'schoolYear'));
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
                Graduate::updateOrCreate([
                    'last_name' => User::formatString($data['Last Name']),
                    'first_name' => User::formatString($data['First Name']),
                    'middle_name' => substr(User::formatString($data['M.I.']), 0, 1)
                ], [
                    'graduate_id' => Str::random(),
                    'gender' => User::formatString($data['Gender']),
                    'degree' => User::formatString($data['Degree']),
                    'major' => User::formatString($data['Major']),
                    'department' => User::formatString($request->dept),
                    'school' => User::formatString($request->school),
                    'school_year' => $request->sy,
                    'batch' => User::formatString($request->batch),
                    'image_uri' => null
                ]);
            }

            $csvFile->delete();

            return redirect()->route('graduates');

        } catch (DecryptException $e) {
            $e->getMessage();
        }
    }
}

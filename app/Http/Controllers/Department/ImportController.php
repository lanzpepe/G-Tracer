<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\CsvFile;
use App\Models\Graduate;
use App\Models\AcademicYear;
use App\Models\Batch;
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
        $admin = DepartmentController::department();
        $schoolYears = AcademicYear::all()->sortByDesc('school_year');
        $batches = Batch::all()->sortBy('name');

        return view('department.import', compact('admin', 'schoolYears', 'batches'));
    }

    public function parseImport(Request $request)
    {
        $schoolYear = $request->sy;
        $batch = $request->batch;
        $schoolYears = AcademicYear::all()->sortByDesc('school_year');
        $batches = Batch::all()->sortBy('name');
        $admin = DepartmentController::department();

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
                Graduate::create([
                    'graduate_id' => Str::random(),
                    'last_name' => $data['Last Name'],
                    'first_name' => $data['First Name'],
                    'middle_name' => $data['Middle Initial'],
                    'suffix' => $data['Suffix'],
                    'gender' => $data['Gender'],
                    'degree' => $data['Degree'],
                    'major' => $data['Major'],
                    'department' => $request->dept,
                    'school' => $request->school,
                    'school_year' => $request->sy,
                    'batch' => $request->batch,
                    'image_uri' => 'default'
                ]);
            }

            $csvFile->delete();

            return redirect()->route('graduates');

        } catch (DecryptException $e) {
            $e->getMessage();
        }
    }
}

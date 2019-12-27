<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Gender;
use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraduateController extends Controller
{
    public function graduates()
    {
        $admin = DepartmentController::department();
        $genders = Gender::all();
        $graduates = Graduate::all();
        $academicYears = AcademicYear::all()->sortByDesc('school_year');
        $batches = Batch::all()->sortBy('name');

        return view('department.graduates', compact('admin', 'academicYears', 'batches',
            'genders', 'graduates'));
    }

    public function addGraduate()
    {
        $admin = $this->department();

        return view('dashboard.add-graduate', compact('admin'));
    }

    public function addEntry(Request $request)
    {
        DB::table('graduates')->insert([
        [
            'graduate_id' => $request->input('idnumber'),
            'last_name' => $request->input('lastname'),
            'first_name' => $request->input('firstname'),
            'middle_name' => $request->input('middlename'),
            'suffix' => $request->input('suffix'),
            'gender' => $request->input('gender'),
            'degree' => $request->input('degree'),
            'major' => $request->input('major'),
            'image_uri'=> ''
        ]
        ]);

        return view('manualentry');
    }
}

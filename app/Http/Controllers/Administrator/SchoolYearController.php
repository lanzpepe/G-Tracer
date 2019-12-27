<?php

namespace App\Http\Controllers\Administrator;

use App\Models\AcademicYear;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolYearRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolYearController extends Controller
{
    public function schoolYears(Request $request)
    {
        $admin = AdminController::admin();
        $years = AcademicYear::orderByDesc('school_year')->paginate(10);
        $page = $request->page;

        return view('administrator.school_year', compact('admin', 'years', 'page'));
    }

    public function addSchoolYear(StoreSchoolYearRequest $request)
    {
        $validated = $request->validated();

        if ($validated) {
            $sy = new AcademicYear();
            $sy->id = Str::random();
            $sy->school_year = $request->sy;
            $sy->save();

            return back()->with('success', "School year added successfully.");
        }
        else {
            return back()->withInput()->withErrors($validated);
        }
    }

    public function markSchoolYear($sy) {
        $sy = AcademicYear::where('school_year', $sy)->first();

        return response()->json(compact('sy'));
    }

    public function removeSchoolYear($sy) {
        $sy = AcademicYear::where('school_year', $sy);

        if ($sy) {
            $sy->delete();
        }

        return back()->with('success', "School year removed successfully.");
    }
}
<?php

namespace App\Http\Controllers\Administrator;

use App\Models\School;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function schools(Request $request)
    {
        $admin = AdminController::admin();
        $schools = School::orderBy('name')->paginate(10);
        $page = $request->page;

        return view('administrator.school', compact('admin', 'schools', 'page'));
    }

    public function addSchool(StoreSchoolRequest $request)
    {
        $validated = $request->validated();

        if ($validated) {
            $school = new School();
            $school->id = Str::random();
            $school->name = strtoupper($request->school);
            $school->save();

            return back()->with('success', "School added successfully.");
        }
        else {
            return back()->withInput()->withErrors($validated);
        }
    }

    public function markSchool($schoolName)
    {
        $school = School::where('name', $schoolName)->first();

        return response()->json(compact('school'));
    }

    public function removeSchool($schoolName)
    {
        $school = School::where('name', $schoolName)->first();

        if ($school)
            $school->delete();

        return back()->with('success', "School removed successfully.");
    }
}

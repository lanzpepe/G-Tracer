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
        $schools = School::orderBy('name')->paginate(15);
        $page = $request->page;

        return view('administrator.school', compact('admin', 'schools', 'page'));
    }

    public function addSchool(StoreSchoolRequest $request)
    {
        $data = $request->validated();

        $school = new School();
        $school->id = Str::random();
        $school->name = AdminController::formatString($data['school']);
        $school->save();

        return back()->with('success', "School added successfully.");
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

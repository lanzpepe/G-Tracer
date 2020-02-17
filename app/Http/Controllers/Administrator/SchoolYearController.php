<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolYearRequest;
use App\Models\AcademicYear;
use App\Models\Admin;
use Illuminate\Support\Str;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::authUser();
        $years = AcademicYear::orderByDesc('school_year')->paginate(15);
        $page = request()->page;

        return view('administrator.school_year', compact('admin', 'years', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolYearRequest $request)
    {
        $data = $request->validated();

        AcademicYear::create([
            'school_year' => $data['sy']
        ]);

        return back()->with('success', "School year added successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sy = AcademicYear::find($id);

        return response()->json(compact('sy'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sy = AcademicYear::find($id);

        if ($sy) {
            $sy->delete();
        }

        return back()->with('success', "School year removed successfully.");
    }
}

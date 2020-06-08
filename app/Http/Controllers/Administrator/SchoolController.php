<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolRequest;
use App\Models\Admin;
use App\Models\School;
use App\Traits\StaticTrait;
use Illuminate\Support\Str;

class SchoolController extends Controller
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
        $schools = School::orderBy('name')->paginate(15);
        $page = request()->page;

        return view('administrator.school', compact('admin', 'schools', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolRequest $request)
    {
        $imagePath = null; $data = $request->validated();
        $school = $this->capitalize($data['school']);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $location = "logos/school/{$school}";
            $imagePath = rawurlencode($file->storeAs($location, "{$school}.{$file->getClientOriginalExtension()}", 'public'));
        }

        School::create([
            'id' => Str::random(),
            'name' => $school,
            'logo' => $imagePath
        ]);

        return back()->with('success', "School added successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = School::find($id);

        return response()->json(compact('school'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);

        if ($school)
            $school->delete();

        return back()->with('success', "School removed successfully.");
    }
}

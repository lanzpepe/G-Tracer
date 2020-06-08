<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Traits\StaticTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
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
        $depts = Department::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $schools = School::orderBy('name')->get();
        $genders = Gender::orderByDesc('name')->get();
        $admins = Admin::orderBy('username')->paginate(10);
        $page = request()->page;

        return view('administrator.account', compact('admin', 'admins', 'depts', 'genders', 'roles', 'schools', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $data = $request->validated();
        $roleId = Role::where('name', $data['role'])->first()->id;
        $deptId = Department::where('name', $data['dept'])->first()->id;
        $schoolId = School::where('name', $data['school'])->first()->id;

        if ($request->btnAccount == 'added') {
            $user = User::create([
                'user_id' => Str::uuid(),
                'last_name' => $this->capitalize($data['lastname']),
                'first_name' => $this->capitalize($data['firstname']),
                'middle_name' => substr($this->capitalize($data['midname']), 0, 1),
                'gender' => $this->capitalize($data['gender']),
                'birth_date' => $data['dob'],
                'image_uri' => null
            ]);

            $user->admin()->create([
                'admin_id' => Str::uuid(),
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'user_id' => $user->user_id
            ]);

            $user->admin->roles()->attach($roleId);
            $user->admin->departments()->attach($deptId);
            $user->admin->schools()->attach($schoolId);

            return back()->with('success', "User {$request->btnAccount} successfully.");
        }
        else {
            $user = User::updateOrCreate([
                'user_id' => $request->userId
            ], [
                'last_name' => $this->capitalize($data['lastname']),
                'first_name' => $this->capitalize($data['firstname']),
                'middle_name' => substr($this->capitalize($data['midname']), 0, 1),
                'gender' => $this->capitalize($data['gender']),
                'birth_date' => $data['dob'],
                'image_uri' => null
            ]);

            $user->admin->departments()->sync($deptId);
            $user->admin->schools()->sync($schoolId);
            $user->admin->roles()->sync($roleId);

            return back()->with('success', "User {$request->btnAccount} successfully.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::with(['user', 'departments', 'schools', 'roles'])->find($id);

        return response()->json(compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::with(['user', 'departments', 'schools', 'roles'])->find($id);

        return response()->json(compact('admin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Admin::find($id)->user;

        if ($user) {
            $user->delete();
        }

        return back()->with('success', "User removed successfully.");
    }
}

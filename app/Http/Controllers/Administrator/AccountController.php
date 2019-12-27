<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function accounts(Request $request)
    {
        $admin = AdminController::admin();
        $depts = Department::all();
        $roles = Role::all();
        $schools = School::all();
        $genders = Gender::orderByDesc('name')->get();
        $admins = Admin::orderBy('username')->paginate(10);
        $page = $request->page;

        return view('administrator.account', compact('admin', 'admins', 'depts', 'genders', 'roles', 'schools', 'page'));
    }

    public function addAccount(StoreAccountRequest $request)
    {
        $roleId = Role::where('name', $request->role)->first()->id;
        $deptId = Department::where('name', $request->department)->first()->id;
        $schoolId = School::where('name', $request->school)->first()->id;
        $validated = $request->validated();

        if ($validated) {
            if ($request->btnAccount == 'add') {
                $user = new User(); $admin = new Admin();

                $user->user_id = Str::random();
                $user->last_name = strtoupper($request->lastname);
                $user->first_name = strtoupper($request->firstname);
                $user->middle_name = substr(strtoupper($request->midname), 0, 1);
                $user->gender = strtoupper($request->gender);
                $user->birth_date = strtoupper($request->dob);
                $user->image_uri = null;
                $user->save();

                $admin->admin_id = Str::random();
                $admin->username = $request->username;
                $admin->password = Hash::make($request->password);
                $admin->user_id = $user->user_id;
                $admin->save();

                $admin->roles()->attach($roleId);
                $admin->departments()->attach($deptId);
                $admin->schools()->attach($schoolId);

                return back()->with('success', "User added successfully.");
            }
            else {
                $user = User::where('last_name', $request->lastname)->where('first_name', $request->firstname)->first();

                $user->last_name = strtoupper($request->lastname);
                $user->first_name = strtoupper($request->firstname);
                $user->middle_name = substr(strtoupper($request->midname), 0, 1);
                $user->gender = strtoupper($request->gender);
                $user->birth_date = strtoupper($request->dob);
                $user->image_uri = null;
                $user->save();

                $admin = Admin::find($user->admins()->first()->admin_id);

                $admin->departments()->sync($deptId);
                $admin->schools()->sync($schoolId);
                $admin->roles()->sync($roleId);

                return back()->with('success', "User modified successfully.");
            }
        }
        else {
            return back()->withInput()->withErrors($validated);
        }
    }

    public function markAccount($username)
    {
        $admin = Admin::with(['user', 'departments', 'schools', 'roles'])
                ->where('username', $username)->first();

        return response()->json(compact('admin'));
    }

    public function removeAccount($username)
    {
        $user = Admin::where('username', $username)->first()->user;

        if ($user) {
            $user->delete();
        }

        return back()->with('success', "User removed successfully.");
    }
}

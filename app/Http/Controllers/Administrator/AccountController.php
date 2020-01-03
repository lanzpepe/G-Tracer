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
        $depts = Department::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $schools = School::orderBy('name')->get();
        $genders = Gender::orderByDesc('name')->get();
        $admins = Admin::orderBy('username')->paginate(10);
        $page = $request->page;

        return view('administrator.account', compact('admin', 'admins', 'depts', 'genders', 'roles', 'schools', 'page'));
    }

    public function addAccount(StoreAccountRequest $request)
    {
        $data = $request->validated();
        $roleId = Role::where('name', $data['role'])->first()->id;
        $deptId = Department::where('name', $data['dept'])->first()->id;
        $schoolId = School::where('name', $data['school'])->first()->id;

        if ($request->btnAccount == 'added') {
            $user = User::create([
                'user_id' => Str::random(),
                'last_name' => AdminController::formatString($data['lastname']),
                'first_name' => AdminController::formatString($data['firstname']),
                'middle_name' => substr(AdminController::formatString($data['midname']), 0, 1),
                'gender' => AdminController::formatString($data['gender']),
                'birth_date' => $data['dob'],
                'image_uri' => null
            ]);

            $admin = Admin::create([
                'admin_id' => Str::random(),
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'user_id' => $user->user_id
            ]);

            $admin->roles()->attach($roleId);
            $admin->departments()->attach($deptId);
            $admin->schools()->attach($schoolId);

            return back()->with('success', "User {$request->btnAccount} successfully.");
        }
        else {
            $user = User::updateOrCreate([
                'last_name' => AdminController::formatString($data['lastname']),
                'first_name' => AdminController::formatString($data['firstname'])
            ], [
                'middle_name' => substr(AdminController::formatString($data['midname']), 0, 1),
                'gender' => AdminController::formatString($data['gender']),
                'birth_date' => $data['dob'],
                'image_uri' => null
            ]);

            $admin = Admin::find($user->admins()->first()->admin_id);

            $admin->departments()->sync($deptId);
            $admin->schools()->sync($schoolId);
            $admin->roles()->sync($roleId);

            return back()->with('success', "User {$request->btnAccount} successfully.");
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

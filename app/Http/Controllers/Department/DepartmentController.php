<?php

namespace App\Http\Controllers\Department;

use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $admin = Admin::authUser();

        return view('home', compact('admin'));
    }

    public function profile()
    {
        $admin = Admin::authUser();
        $user = User::find($admin->user_id);

        return view('layout.profile', compact('admin', 'user'));
    }

    public function report()
    {
        $admin = Admin::authUser();

        return view('department.report', compact('admin'));
    }
}

<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;

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
}

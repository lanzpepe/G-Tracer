<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class FileManagerController extends Controller
{
    public function index()
    {
        $admin = Admin::authUser();

        return view('department.file_manager', compact('admin'));
    }
}

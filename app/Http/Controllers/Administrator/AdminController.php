<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public static function admin()
    {
        return Admin::find(Auth::user()->admin_id)->roles()->first()->name;
    }

    public function index()
    {
        $admin = $this->admin();

        return view('home', compact('admin'));
    }

    public function profile()
    {
        $admin = $this->admin();

        return view('administrator.profile', compact('admin'));
    }
}

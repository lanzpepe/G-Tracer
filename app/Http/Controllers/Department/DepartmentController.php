<?php

namespace App\Http\Controllers\Department;

use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public static function department()
    {
        return Admin::find(Auth::user()->admin_id);
    }

    public static function formatString(string $tag)
    {
        $words = ['Of', 'The'];
        $regex = '/\b(' . implode('|', $words) . ')\b/i';

        return preg_replace_callback($regex, function ($matches) {
            return strtolower($matches[1]);
        }, ucwords($tag));
    }

    public function index()
    {
        $admin = $this->department();

        return view('home', compact('admin'));
    }

    public function profile()
    {
        $admin = $this->department();
        $user = User::find($admin->user_id);

        return view('layout.profile', compact('admin', 'user'));
    }

    public function report()
    {
        $admin = $this->department();

        return view('department.report', compact('admin'));
    }
}

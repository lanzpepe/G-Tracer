<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public static function admin()
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
        $admin = $this->admin();

        return view('home', compact('admin'));
    }

    public function profile()
    {
        $admin = $this->admin();
        $user = User::find($admin->user_id);

        return view('layout.profile', compact('admin', 'user'));
    }
}

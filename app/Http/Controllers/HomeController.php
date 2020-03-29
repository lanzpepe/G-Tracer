<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Graduate;
use App\Models\Notification;
use App\Models\Page;
use App\Models\User;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use StaticTrait;

    public function token(Request $request)
    {
        $admin = Admin::authUser();

        if ($request->ajax()) {
            $result = User::updateOrCreate([
                'user_id' => $admin->user_id
            ], [
                'device_token' => $request->token
            ]);

            if ($result) {
                echo('Token added successfully.');
            }
            else {
                echo('Failed to add token.');
            }
        }
    }

    public function notify(Request $request)
    {
        $tokens = collect();

        $admins = Admin::whereHas('departments', function ($query) use ($request) {
            return $query->where('name', $request->department);
        })->whereHas('schools', function ($query) use ($request) {
            return $query->where('name', $request->school);
        })->get();

        foreach ($admins as $admin) {
            $tokens->push($admin->user->device_token);
        }

        $token = $tokens->unique()->values()->all();

        $this->sendNotification($token, $request->title, $request->message, null, "default");
    }

    public function read(Request $request)
    {
        if ($request->ajax()) {
            $graduates = Graduate::all();
            $notifications = Notification::unread();

            return view('layout.notification', compact('notifications', 'graduates'));
        }
    }

    public function showPages()
    {
        $admin = Admin::authUser();
        $pages = Admin::find($admin->admin_id)->pages()->get();

        return response()->json(compact('pages'));
    }

    public function storePage(Request $request)
    {
        $admin = Admin::authUser();

        if ($request->ajax()) {
            $page = Page::updateOrCreate([
                'description' => $request->description,
                'url'=> $request->url
            ],[
                'title' => $request->title
            ]);

            $page->admins()->syncWithoutDetaching($admin->admin_id);
        }
    }

    public function fileManager()
    {
        $admin = Admin::authUser();

        return view('department.file_manager', compact('admin'));
    }
}

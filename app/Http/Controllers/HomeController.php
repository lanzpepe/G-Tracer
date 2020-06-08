<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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

    public function notifications(Request $request)
    {
        $admin = Admin::authUser();

        if ($request->ajax()) {
            $notifications = $admin->notifications;

            return view('layout.notification', compact('notifications'));
        }
    }

    public function read(Request $request)
    {
        $admin = Admin::authUser();

        if ($request->ajax()) {
            foreach ($admin->notifications as $notification) {
                if ($notification->data['graduate_id'] == $request->id) {
                    $notification->markAsRead();
                }
            }
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

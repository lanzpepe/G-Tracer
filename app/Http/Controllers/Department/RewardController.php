<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRewardRequest;
use App\Models\Admin;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::authUser();
        $rewards = Reward::whereHas('admins', function ($query) use ($admin) {
            return $query->where('admins.admin_id', $admin->admin_id);
        })->paginate(10);
        $page = request()->page;

        return view('department.reward', compact('admin', 'rewards', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRewardRequest $request)
    {
        $imagePath = null; $admin = Auth::user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $directory = "files/{$admin->admin_id}/images/rewards";

            if (Storage::makeDirectory("public/{$directory}")) {
                $imagePath = $file->storeAs($directory, $file->getClientOriginalName(), 'public');
                $image = Image::make(public_path("storage/{$imagePath}"));
                $image->resize(800, 800);
                $image->save();
                $imagePath = urlencode("storage/{$imagePath}");
            }
        }
        else {
            $imagePath = urlencode("storage/logos/department/{$admin->school}/{$admin->department}.png");
        }

        $reward = Reward::updateOrCreate([
            'id' => $request->_value ?? Str::random()
        ], [
            'name' => $data['name'],
            'description' => $data['description'],
            'points' => $data['points'],
            'image_uri' => $imagePath
        ]);

        if ($request->btnReward == 'added') {
            $reward->admins()->attach($admin->admin_id, ['quantity' => $data['quantity']]);
        }
        else {
            $reward->admins()->syncWithoutDetaching([$admin->admin_id => ['quantity' => $data['quantity']]]);
        }

        return back()->with('success', "Item {$request->btnReward} successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reward = Reward::find($id);

        return response()->json(compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reward = Reward::with('admins')->find($id);

        return response()->json(compact('reward'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminId = Admin::authUser()->admin_id;
        $reward = Reward::find($id);

        if ($reward) {
            $reward->admins()->detach($adminId);
        }

        return back()->with('success', "Item removed successfully.");
    }
}

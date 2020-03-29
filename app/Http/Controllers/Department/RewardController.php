<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRewardRequest;
use App\Models\Admin;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $rewards = Reward::paginate(10);
        $page = request()->page;

        return view('administrator.reward', compact('admin', 'rewards', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRewardRequest $request)
    {
        $imagePath = null; $adminId = Auth::user()->admin_id;
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $directory = "files/{$adminId}/images/rewards";

            if (Storage::makeDirectory("public/{$directory}")) {
                $imagePath = $file->storeAs($directory, $file->getClientOriginalName(), 'public');
                $image = Image::make(public_path("storage/{$imagePath}"));
                $image->resize(800, 800);
                $image->save();
            }
        }

        if ($request->btnReward == 'added') {
            Reward::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'points' => $data['points'],
                'quantity' => $data['quantity'],
                'image_uri' => urlencode($imagePath)
            ]);
        }
        else {
            Reward::updateOrCreate([
                'id' => $request->itemId
            ], [
                'name' => $data['name'],
                'description' => $data['description'],
                'points' => $data['points'],
                'quantity' => $data['quantity'],
                'image_uri' => urlencode($imagePath)
            ]);
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
        $reward = Reward::find($id);

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
        $reward = Reward::find($id);

        if ($reward) {
            $reward->delete();
        }

        return back()->with('success', "Item removed successfully.");
    }
}

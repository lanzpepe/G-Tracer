<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Admin;
use App\Models\Graduate;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::authUser();
        $tasks = Task::paginate(10);
        $max = 100; // maximum points to give
        $page = request()->page;

        return view('department.task', compact('admin', 'max', 'page', 'tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $admin = Admin::authUser();
        $graduates = Graduate::where('department', $admin->departments->first()->name)
                    ->where('school', $admin->schools->first()->name)->get();
        $data = $request->validated();
        $task = Task::updateOrcreate([
            'name' => $data['task'],
            'deadline' => $data['deadline'],
            'reward_points' => $data['reward'],
            'status' => true
        ]);

        if ($data['apply'] == 'all') {
            foreach ($graduates as $graduate) {
                $task->graduates()->syncWithoutDetaching($graduate->graduate_id);
            }
        }

        return back()->with('message', 'Task added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $project_id = $request->input('project_id');

        $tasks = Task::where('project_id', $project_id)->orderBy('priority')->get();

        $projects = Project::all();

        return view('tasks.index', compact('tasks', 'projects', 'project_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id'
        ]);

        $task = Task::create([
            'name' => $request->name,
            'priority' => Task::where('project_id', $request->project_id)->max('priority') + 1,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index', ['project_id' => $task->project_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // dd($request->all());
   
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);


        $task->update($validated);

        return redirect()->route('tasks.index', ['project_id' => $task->project_id])
        ->with('success', ucfirst($task->name).' updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $project = $task->project_id;

        $task->delete();

        return redirect()->route('tasks.index', ['project_id' => $project]);
    }

    public function order(Request $request)
    {
        $tasks = $request->input('tasks');

        foreach ($tasks as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}

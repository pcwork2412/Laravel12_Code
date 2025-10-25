<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
public function index(Request $request)
{
    if ($request->wantsJson()) {
        return Task::latest()->get();
    }
    return view('tasks.index');
}

public function store(Request $request)
{
    $task = Task::create($request->all());
    return response()->json($task);
}

public function show(Task $task)
{
    return response()->json($task);
}

public function update(Request $request, Task $task)
{
    $task->update($request->all());
    return response()->json($task);
}

public function destroy(Task $task)
{
    $task->delete();
    return response()->json(['message' => 'Deleted']);
}

}
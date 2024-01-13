<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{
    public function index()
{
    return view('tasks.index');
}

public function fetchTasks()
{
    $tasks = Task::all(); 
    return response()->json(['data' => $tasks]); 
}

    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task created successfully']);
    }
    public function completeTask($taskID)
{
    $task = Task::find($taskID);
    
    if ($task) {
        $task->completed = 1;
        $task->save();
        return response()->json(['message' => 'Task marked as completed']);
    }

    return response()->json(['message' => 'Task not found'], 404);
}

public function deleteTask($id)
{
    $task = Task::find($id);

    if ($task) {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    return response()->json(['message' => 'Task not found'], 404);
}

}

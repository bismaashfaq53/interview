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
    $tasks = Task::all(); // Fetch tasks from the database
    return response()->json(['data' => $tasks]); // Return tasks as JSON response
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
    // Find the task by ID and update the 'completed' field to 1
    $task = Task::find($taskID);
    
    if ($task) {
        $task->completed = 1;
        $task->save();
        return response()->json(['message' => 'Task marked as completed']);
    }

    return response()->json(['message' => 'Task not found'], 404);
}

}

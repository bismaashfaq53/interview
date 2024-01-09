<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(10); // Fetch tasks with pagination, adjust per your needs
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task created successfully']);
    }
    public function completeTask($id)
{
    // Find the task by ID and update the 'completed' field to 1
    $task = Task::find($id);
    
    if ($task) {
        $task->completed = 1;
        $task->save();
        return response()->json(['message' => 'Task marked as completed']);
    }

    return response()->json(['message' => 'Task not found'], 404);
}

}

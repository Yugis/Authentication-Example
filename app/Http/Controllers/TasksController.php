<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success(data: Task::get(), message: 'Tasks Fetched.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'description' => ['required', 'max:255'],
            'deadline' => ['required', 'date'],
        ]);

        $task = Task::create($validated);

        return $task ?
            response()->success(data: $task, message: 'Task Fetched.')
            : response()->failure(statusCode: 500);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->success(data: $task);
    }

    public function update(Task $task, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'description' => ['max:255'],
            'deadline' => ['date'],
            'department_id' => ['exists:departments,id']
        ]);

        $task->update($validated);

        return $task ?
            response()->success(data: $task)
            : response()->failure(statusCode: 500);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->success(message: 'Task Deleted.');
    }
}

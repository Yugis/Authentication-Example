<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TasksManagementController extends Controller
{
    public function store(Task $task, Request $request): JsonResponse
    {
        $request->validate([
            'department_id' => ['required', 'exists:departments,id']
        ]);

        $task->assignToDepartment($request->department_id);

        return response()->success(data: $task, statusCode: 201, message: 'Task assigned successfully!');
    }

    public function update(Task $task, Request $request): JsonResponse
    {
        if ($task->department_id !== $request->user()->department_id) {
            throw new NotFoundHttpException();
        }

        $request->validate([
            'status' => ['required', 'boolean']
        ]);

        $task->update(['status' => $request->status]);

        return response()->success(data: $task, message: 'Task Updated.');
    }

    public function destroy(Task $task, Request $request): JsonResponse
    {
        $task->revokeTaskAccess();

        return response()->success(data: $task, statusCode: 201, message: 'Task revoked.');
    }
}

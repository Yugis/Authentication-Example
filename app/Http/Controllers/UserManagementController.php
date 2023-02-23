<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __invoke(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'department_id' => ['required', 'exists:departments,id']
        ]);

        $user->assignToDepartment($request->department_id);

        return response()->success(data: $user, statusCode: 201, message: 'User assigned to department.');
    }
}

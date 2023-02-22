<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success(data: User::get());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['required', 'exists:departments,id']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return $user ?
            response()->success(data: $user, message: 'User Created!')
            : response()->failure(statusCode: 500);
    }

    public function show(User $task): JsonResponse
    {
        return response()->success(data: $task);
    }

    public function update(User $task, Request $request)
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

    public function destroy(User $task): JsonResponse
    {
        $task->delete();

        return response()->success(message: 'Task Deleted.');
    }
}

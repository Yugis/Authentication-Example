<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success(data: User::latest('id')->get(), message: 'Users Fetched');
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
            response()->success(data: $user, message: 'User Created')
            : response()->failure(statusCode: 500);
    }

    public function show(User $user): JsonResponse
    {
        return response()->success(data: $user, message: 'User Fetched');
    }

    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'department_id' => ['required', 'exists:departments,id']
        ]);

        $user->update($validated);

        return $user ?
            response()->success(data: $user, message: 'User updated')
            : response()->failure(statusCode: 500);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->success(message: 'User Deleted');
    }
}

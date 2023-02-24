<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\TasksManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->prefix('tasks')->group(function () {
    Route::middleware(['role:super admin'])->group(function () {
        Route::post('store', [TasksController::class, 'store']);
        Route::patch('{task}/update', [TasksController::class, 'update']);
        Route::get('{task}', [TasksController::class, 'show']);
        Route::delete('{task}/delete', [TasksController::class, 'destroy']);
    });

    Route::middleware(['permission:read task'])->get('/', [TasksController::class, 'index']);

    Route::middleware(['permission:assign task'])->post('{task}/assign', [TasksManagementController::class, 'store']);
    Route::middleware(['permission:update task status'])->patch('{task}/updateStatus', [TasksManagementController::class, 'update']);
    Route::middleware(['permission:revoke task'])->post('{task}/revoke', [TasksManagementController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->prefix('users')->group(function () {
    Route::middleware(['role:super admin'])->group(function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::post('store', [UsersController::class, 'store']);
        Route::get('{user}', [UsersController::class, 'show']);
        Route::patch('{user}/update', [UsersController::class, 'update']);
        Route::delete('{user}/delete', [UsersController::class, 'destroy']);
        Route::post('{user}/assign', UserManagementController::class);
    });
});

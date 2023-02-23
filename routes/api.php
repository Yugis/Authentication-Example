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

Route::prefix('tasks')->group(function () {
    Route::get('/', [TasksController::class, 'index']);
    Route::post('store', [TasksController::class, 'store']);
    Route::get('{task}', [TasksController::class, 'show']);
    Route::patch('{task}/update', [TasksController::class, 'update']);
    Route::delete('{task}/delete', [TasksController::class, 'destroy']);

    Route::post('{task}/assign', [TasksManagementController::class, 'store']);
    Route::patch('{task}/updateStatus', [TasksManagementController::class, 'update']);
    Route::post('{task}/revoke', [TasksManagementController::class, 'destroy']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::post('store', [UsersController::class, 'store']);
    Route::get('{user}', [UsersController::class, 'show']);
    Route::patch('{user}/update', [UsersController::class, 'update']);
    Route::delete('{user}/delete', [UsersController::class, 'destroy']);

    Route::post('{user}/assign', UserManagementController::class);
});

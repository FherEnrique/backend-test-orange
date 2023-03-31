<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ---Auth endpoints--
Route::post('/signup', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'login']);

// ---User CRUD endpoints--
Route::get('/users', [UserController::class, 'readAllUsers'])->middleware('auth:sanctum');
Route::get('/users/{user}', [UserController::class, 'readUser'])->middleware('auth:sanctum');
Route::post('/users', [UserController::class, 'createUser'])->middleware('auth:sanctum');
Route::patch('/users/{user}', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::delete('/users/{user}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
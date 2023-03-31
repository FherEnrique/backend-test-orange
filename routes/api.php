<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\App\ProductController;

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

// --Product CRUD endpoints --
Route::get('/products', [ProductController::class, 'readAllProducts'])->middleware('auth:sanctum');
Route::get('/products/{id}', [ProductController::class, 'readProduct'])->middleware('auth:sanctum');
Route::post('/products', [ProductController::class, 'createProduct'])->middleware('auth:sanctum');
Route::patch('/products/{id}', [ProductController::class, 'updateProduct'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->middleware('auth:sanctum');

// --Reset password endpoints--
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function readAllUsers(Request $request) {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1',
            'name' => 'string'
        ]);

        $query = User::query();

        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
    
        $users = $query->paginate($request->per_page ?? 10, ['*'], 'page', $request->page ?? 1);
    
        return response()->json([
            'data' => $query->get(),
            'pagination' => [
                'page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
            ]
        ], 200);
    }

    public function readUser($id) {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'data' => $user,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
    }

    public function createUser(Request $request) {
        $validateRequest = $request->validate([
            'name' =>'required|max:255',
            'email' =>'required|email|max:255|unique:users',
            'password' =>'required|min:6|max:255',
            'phone_number' => ['required', 'regex:/^(2|6|7)\d{7}$/'], 
            'username' => 'required|min:6|max:255|unique:users', 
            'date_birth' => 'required|date|before:today',
        ]);

        $user = User::create($validateRequest);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function updateUser(Request $request, $id) {
        try {
            $user = User::findOrFail($id);

            $validateRequest = $request->validate([
                'name' =>'max:255',
                'email' =>'email|max:255|unique:users,email,'.$user->id,
                'password' =>'min:6|max:255',
                'phone_number' => 'regex:/^(2|6|7)\d{7}$/', 
                'username' => 'min:6|max:255|unique:users,username,'.$user->id, 
                'date_birth' => 'date|before:today',
            ]);

            $user->update($validateRequest);

            return response()->json([
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }

    }

    public function deleteUser($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
    }
}
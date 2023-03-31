<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function createUser(Request $request) {  
        $validateRequest = $request->validate([
            'name' =>'required|max:255',
            'email' =>'required|email|max:255|unique:users',
            'password' =>'required|min:6|max:255',
            'phone_number' => ['required', 'regex:/^(2|6|7)\d{7}$/'], 
            'username' => 'required|min:6|max:255|unique:users', 
            'date_birth' => 'required|date|before:today',
        ]);

        $newUser = User::create($validateRequest);

        $token = $newUser->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer'
        ], 201);
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}

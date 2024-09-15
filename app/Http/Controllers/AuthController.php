<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }



        $token = $user->createToken($user->name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 200);

    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You are logged out.'
        ], 200);
    }
}

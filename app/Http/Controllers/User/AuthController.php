<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create($fields);

        Mail::to($user->email)->send(new UserRegisteredMail($user));

        $token = $user->createToken($request->name);


        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'message' => 'The user has successfully created the profile',
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
            'token' => $token->plainTextToken,
            'message' => 'The user has successfully logged in',
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

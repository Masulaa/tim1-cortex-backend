<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function details(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);

    }

    public function edit(UpdateUserRequest $request)
    {
        $fields = $request->validated();
        $user = $request->user()->update($fields);
        return response()->json([
            'message' => 'The user has successfully updated the profile',
            'user' => $fields
        ], 200);

    }
}

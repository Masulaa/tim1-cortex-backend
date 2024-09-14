<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function details(Request $request)
    {
        return $request->user();


    }

    public function edit(UpdateUserRequest $request)
    {
        $fields = $request->validated();
        $user = $request->user()->update($fields);
        return [
            'message' => 'The user has successfully updated the profile',
            'user' => $fields
        ];

    }
}

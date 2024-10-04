<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\{
    AdminUserStoreRequest,
    AdminUserUpdateRequest
};

use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();

        return view('admin.users.user_list', compact('users'));
    }

    public function destroy(Request $request, $id)
    {

        $userToDelete = User::findOrFail($id);
        $userToDelete->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function store(AdminUserStoreRequest $request)
    {

        $newUser = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $newUser->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(Request $request, $id)
    {
        $userToEdit = User::findOrFail($id);

        return view('admin.users.user_edit', compact('userToEdit'));
    }

    public function update(AdminUserUpdateRequest $request, $id)
    {
        $userToUpdate = User::findOrFail($id);
        if ($request->filled('email')) {
            $userToUpdate->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $userToUpdate->password = bcrypt($request->input('password'));
        }

        $userToUpdate->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
}

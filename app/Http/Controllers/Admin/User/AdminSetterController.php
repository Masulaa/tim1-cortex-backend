<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class AdminSetterController extends Controller
{

    public function setAdmin(Request $request, $id)
    {
        $userToSetAdmin = User::findOrFail($id);
        $userToSetAdmin->is_admin = true;
        $userToSetAdmin->save();

        return redirect()->route('admin.users.index')->with('success', 'User set as admin successfully');
    }

    public function removeAdmin(Request $request, $id)
    {
        $userToRemoveAdmin = User::findOrFail($id);
        $userToRemoveAdmin->is_admin = false;
        $userToRemoveAdmin->save();

        return redirect()->route('admin.users.index')->with('success', 'Admin privileges removed successfully');
    }
}

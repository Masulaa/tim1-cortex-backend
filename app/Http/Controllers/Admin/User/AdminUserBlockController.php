<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminUserBlockController extends Controller
{
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User blocked successfully');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User unblocked successfully');
    }
}

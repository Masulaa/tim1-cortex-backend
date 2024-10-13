<?php

namespace App\Http\Controllers\Admin\User;

use App\Mail\UserUnblockedMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserBlockedMail;
use Illuminate\Support\Facades\Mail;


use App\Http\Controllers\Controller;

class AdminUserBlockController extends Controller
{
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();
        Mail::to($user->email)->send(new UserBlockedMail($user));

        return redirect()->route('admin.users.index')->with('success', 'User blocked successfully');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();
        Mail::to($user->email)->send(new UserUnblockedMail($user));

        return redirect()->route('admin.users.index')->with('success', 'User unblocked successfully');
    }
}

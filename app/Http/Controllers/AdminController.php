<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller {
    public function banUser(Request $request, $id) {
        $user = User::find(Auth::user()->id);
        $bannedUser = User::where('id', $id);

        /* if($request->user()->cannot('ban', $bannedUser)) {
            return redirect()->back()->with('error', 'You cannot ban a user.');
        } */

        $bannedUser->update(['is_banned' => true]);
        return redirect()->back();
    }
    
    public function unbanUser($id) {
        User::where('id', $id)->update(['is_banned' => false]);
        return redirect()->back();
    }

    public function dashboard() {
        $users = User::all();
        return view('pages.dashboard', compact('users'));
    }

    public function regiterUser(Request $request) {
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|max:12|unique:users',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->withSuccess('User added successfully.');

    }
}

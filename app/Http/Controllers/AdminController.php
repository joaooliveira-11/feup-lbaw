<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
    
}

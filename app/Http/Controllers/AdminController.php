<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AdminController extends Controller {
    public function banUser($id) {
        User::where('id', $id)->update(['is_banned' => true]);
        return redirect()->back();
    }
    
    public function unbanUser($id) {
        User::where('id', $id)->update(['is_banned' => false]);
        return redirect()->back();
    }
    
}

<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function userNotifications(){
        $user = Auth::user();
        $notifications = $user->notifications()->get();
        return response()->json([
            'notifications' => $notifications,
        ]);
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;

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

    public function dismiss(Request $request){
        $notification = Notification::find($request->get('notificationId'));
        $notification->viewed = true;
        $notification->save();
        return response()->json([
            'success' => 'Notification dismissed successfully!',
        ]);
    }

    public function show(){
        $notifications = Notification::where('emited_to', Auth::user()->id)
                        //->where('viewed', false)
                        ->orderBy('create_date', 'desc')
                        ->get();

        if($notifications->count() == 0){
            return response()->json([
                'notifications' => $notifications,
                'success' => 'No notifications to show!',
            ]);
        }
        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    
}
?>
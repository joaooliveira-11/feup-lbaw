<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    

    

}
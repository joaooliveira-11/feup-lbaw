<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Invite;

class InviteController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){


        $invite = new Invite();
        $invite->title = "Project Invite";
        $invite->description = "This is an invite to join a project.";
        $invite->create_date = now();
        $invite->invited_by = Auth::user()->id;
        $invite->invited_to = (int) $request->member_id;
        $invite->project_invite = (int) $request->project_id; 
        //$this->authorize('create', $invite); 
        $invite->save(); 

        return response()->json([
            'invite' => $invite,
            'success' => 'Invite created successfully!',
        ]);
    }

}
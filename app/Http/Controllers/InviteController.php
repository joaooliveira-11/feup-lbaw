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

        $validator = Validator::make($request->all(), [
            'title' => 'min:15|string|max:100',        // mudar valores
            'description' => 'min:100|string|max:300' // mudar valores
        ]);

        if ($validator->fails()) {
                return redirect()->route() // mudar a route 
                ->withErrors($validator)
                ->withInput();
        }

        $invite = new Invite();
        $invite->title = $request->title;
        $invite->description = $request->description;
        $invite->create_date = now();
        $invite->invited_by = Auth::user()->id;
        $invite->invited_to = $request->invited_to;
        $invite->project_invite = $request->project_id; // se for passado hidden no forms ou então receber como argumento na função
        
        $this->authorize('create', $invite); 

        $invite->save(); 
    }

}
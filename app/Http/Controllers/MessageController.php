<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;

class MessageController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'content' => 'min:1|string|max:4096'
        ]);

        if ($validator->fails()) {
                return redirect()->route() // mudar a route 
                ->withErrors($validator)
                ->withInput();
        }

        $message = new Message();
        $message->content = $request->content;
        $message->create_date = now();
        $message->message_by = Auth::user()->id;
        $message->project_message = $request->project_id; // se for passado hidden no forms ou então receber como argumento na função
        $this->authorize('create', $message); 

        $message->save(); 
    }

} 

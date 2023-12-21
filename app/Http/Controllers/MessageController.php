<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use App\Events\ChatMessage;
use App\Events\MessageForum;

class MessageController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){

        $message = new Message();
        $message->content = $request->content;
        $message->create_date = now();
        $message->message_by = Auth::user()->id;
        $message->project_message = $request->project_id;
        
        $this->authorize('create', $message);

        $message->save();

        event(new ChatMessage($message->content, $message->message_id, Auth::user()->username, $message->create_date, Auth::user()->photo));
        event(new MessageForum());
    }

    public function delete($id){
        $message = Message::find($id);
        $this->authorize('delete', $message); 
        $message->delete();
        return response()->json([
            'success' => true
        ]);
    }
    
    public function edit($id, Request $request){
        $message = Message::find($id);
        $this->authorize('edit', $message);
        $message->content = $request->content;
        $message->edited = true;
        $message->save();
        return response()->json([
            'message_content' => $message->content,
            'edited' => $message->edited,
        ]);
    }
} 

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
        
        //$this->authorize('create', $message);

        $message->save();

        event(new ChatMessage($message->content, $message->message_id, Auth::user()->username, $message->create_date));
        event(new MessageForum());

        return response()->json([
            'message_id' => $message->message_id,
            'message_content' => $message->content,
            'message_create_date' => $message->create_date,
            'message_message_by' => Auth::user()->username,
        ]);
    }

    public function delete($id){
        $message = Message::find($id);
        $this->authorize('delete', $message); 
        $message->delete();
        return response()->json([
            'success' => true
        ]);
    }

} 

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\TaskComment;

class CommentController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->create_date = now();
        $comment->comment_by = Auth::user()->id;
        $comment->task_comment = $request->task_id;
        
        //$this->authorize('create', $comment);   falta decidir se dá para comentar em qualquer task independentemente do estado dela

        $comment->save();

        event(new TaskComment());

        return response()->json([
            'comment_id' => $comment->comment_id,
            'comment_content' => $comment->content,
            'comment_create_date' => $comment->create_date,
            'comment_comment_by' => Auth::user()->username,
        ]);
    }

    public function delete($id){
        $comment = Comment::find($id);
        $this->authorize('delete', $comment); 
        $comment->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function edit($id, Request $request){
        $comment = Comment::find($id);
        // $this->authorize('edit', $comment);
        $comment->content = $request->content;
        $comment->edited = true;
        $comment->save();
        return response()->json([
            'comment_content' => $comment->content,
        ]);
    }

}
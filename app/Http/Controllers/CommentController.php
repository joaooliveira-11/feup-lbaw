<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
        
        // $this->authorize('create', $comment); 

        $comment->save();

        return response()->json([
            'comment_id' => $comment->comment_id,
            'comment_content' => $comment->content,
            'create_date' => $comment->create_date,
            'comment_edited' => $comment->edited,
        ]);
    }

    public function edit(Request $request){

        $comment_id = $request->comment_id;
        $comment = Comment::find($comment_id);

        $comment->content = $request->content;
        $comment->edited = true;
        
        // $this->authorize('edit', $comment); 

        $comment->save();

        return response()->json([
            'comment_content' => $comment->content,
            'create_date' => $comment->create_date,
            'comment_edited' => $comment->edited,
        ]);
    }

}
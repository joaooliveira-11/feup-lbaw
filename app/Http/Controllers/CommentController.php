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

        $validator = Validator::make($request->all(), [
            'content' => 'min:15|string|max:100'
        ]);

        if ($validator->fails()) {
                return redirect()->route() // mudar a route 
                ->withErrors($validator)
                ->withInput();
        }

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->create_date = now();
        $comment->comment_by = Auth::user()->id;
        $comment->task_comment = $request->task_id; // se for passado hidden no forms ou então receber como argumento na função
        
        $this->authorize('create', $comment); 

        $comment->save(); 
    }

}
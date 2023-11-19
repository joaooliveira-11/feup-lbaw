<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller {
    public function show(int $id){
        $task = Task::find($id);  
        $user = User::find(Auth::user()->id);
        $this->authorize('show', $task);
        return view('partials.task', ['task'=>$task]);
    }

    public function create(Request $request, $project_id){

        $this->authorize('create', $task);    

        // Set task details.
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->project_task = $project_id;
        $task->create_date = now();
        $task->save();
        
        return response()->json($task);
    }
}
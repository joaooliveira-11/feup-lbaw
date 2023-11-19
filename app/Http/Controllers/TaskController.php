<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller {
    public function show(int $id){
        $task = Task::find($id);  
        $user = User::find(Auth::user()->id);
        $this->authorize('show', $task);
        return view('partials.task', ['task'=>$task]);
    }

    public function create(Request $request){

        // $this->authorize('create', $task);    

        // Set task details.
        $project_id = $request->input('project_id');
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->create_date = now();
        $task->finish_date = $request->input('finish_date');
        $task->create_by = Auth::user()->id;
        $task->project_task = $project_id;
        $task->save();
        
        return response()->json($task);
    }

    public function createTaskForm($project_id) : View {
        return view('pages.createTask', ['project_id' => $project_id]);
    }

}
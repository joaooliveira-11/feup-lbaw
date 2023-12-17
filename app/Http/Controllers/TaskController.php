<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Project;

class TaskController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){
        
        $project_id = $request->project_id;

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->create_date = now();
        $task->finish_date = $request->finish_date;
        $task->create_by = Auth::user()->id;
        $task->project_task = $project_id;
        
        $this->authorize('create', $task); 

        $task->save();

        return response()->json([
            'task_title' => $task->title,
            'task_description' => $task->description,
            'task_finish_date' => $task->finish_date,
            'task_url' => url('task/' . $task->task_id),
        ]);
    }

    public function show(int $task_id){
        $task = Task::find($task_id);  
        $this->authorize('show', $task);
        return view('pages.task', ['task'=>$task]);
    }

    public function updatedetails(Request $request){

        $task_id = $request->task_id;
        $task = Task::find($task_id);

        $this->authorize('updatedetails', $task); 

        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->finish_date = $request->finish_date;

        $task->save();
        
        return response()->json([
            'task_title' => $task->title,
            'task_description' => $task->description,
            'task_priority' => $task->priority,
            'task_finish_date' => $task->finish_date,
        ]);
    }

    public function completetask($id){
        $task = Task::find($id);
        $this->authorize('completetask', $task);    

        $task->state = 'completed';
        $task->save();
    
        return response()->json([
            'task' => $task,
        ]);
    }

    public function assign(Request $request){

        $task_id = $request->input('task_id');
        $task = Task::find($task_id);
        $this->authorize('assign', $task);    

        $task->state = 'assigned';
        $task->assigned_to = $request->assign_task_to;
        $task->save();
    
        return view('pages.task', ['task'=>$task]);
    }

    public function search(Request $request){

        $search = strtolower($request->input('filter'));
        $project_id = $request->input('project_id');
        $project = Project::find($project_id);

        if($request->input('statusFilter') == 'all' && $request->input('priorityFilter') == 'all')
            $tasks = $project->tasks()->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->get();
        else if($request->input('statusFilter') != 'all' && $request->input('priorityFilter') == 'all')
            $tasks = $project->tasks()->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->where('state', $request->input('statusFilter'))->get();
        else if($request->input('statusFilter') == 'all' && $request->input('priorityFilter') != 'all')
            $tasks = $project->tasks()->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->where('priority', $request->input('priorityFilter'))->get();
        else
            $tasks = $project->tasks()->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->where('state', $request->input('statusFilter'))->where('priority', $request->input('priorityFilter'))->get();

        return response()->json($tasks);
    }
}

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
        
        if ($request->ajax()) {
            $project = Project::find($project_id);
            $dashboardView = view('project.dashboard', ['project' => $project])->render();
            $tasksView = view('project.tasks', ['project' => $project])->render();
            return response()->json([
                'dashboard' => $dashboardView,
                'tasks' => $tasksView,
            ]);
        } else {
            return redirect()->route('project', ['project_id' => $project_id])
            ->withSuccess('You have successfully created a new task!');
        }
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

        return redirect()->route('task', ['task_id' => $task_id])
            ->withSuccess('You have successfully updated the task details');
    }

    public function completetask(Request $request){

        $task_id = $request->input('task_id');
        $task = Task::find($task_id);
        $this->authorize('completetask', $task);    

        $task->state = 'closed';
        $task->save();
    
        return redirect()->route('task', ['task_id' => $task_id])
            ->withSuccess('You have successfully completed an assigned task');
    }

    public function search(Request $request){
        $search = strtolower($request->input('filter'));
        $project_id = $request->input('project_id');
        $project = Project::find($project_id);
        $tasks = $project->tasks()->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->get();
        return response()->json($tasks);
    }
}

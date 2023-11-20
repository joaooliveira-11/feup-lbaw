<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;

class TaskController extends Controller {

    public function show(int $id){
        $task = Task::find($id);  
        $user = User::find(Auth::user()->id);
        $this->authorize('show', $task);
        return view('pages.task', ['task'=>$task]);
    }

    public function create(Request $request){

        $project_id = $request->input('project_id');

        // Set task details.
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->create_date = now();
        $task->finish_date = $request->input('finish_date');
        $task->create_by = Auth::user()->id;
        $task->project_task = $project_id;
        
        $this->authorize('create', $task); 

        $task->save();
        
        return redirect()->route('project', ['project_id' => $project_id])
            ->withSuccess('You have successfully created a new task!');
            
    }

    public function createTaskForm($project_id) : View {
        return view('pages.createTask', ['project_id' => $project_id]);
    }

    public function editDetailsForm($task_id) : View {
        $task = Task::find($task_id);
        return view('pages.editTaskDetails', ['task' => $task]);
    }

    public function updateDetails(Request $request){

        $task_id = $request->input('task_id');
        $task = Task::find($task_id);

        $this->authorize('updatedetails', $task); 

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->finish_date = $request->input('finish_date');

        $task->save();

        return redirect()->route('task', ['task_id' => $task_id])
            ->withSuccess('You have successfully updated the task details');
    }

}

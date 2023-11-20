<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller {

    public function show(int $id){

        if(!Auth::check()){
            return redirect("/login");
        }

        $project = Project::find($id);  
        $user = User::find(Auth::user()->id);
        $this->authorize('show', $project);
        return view('pages.project', ['project'=>$project]);
    }

    public function create(Request $request) {   

        if(!Auth::check()){
            return redirect("/login");
        }

        $this->authorize('create', Project::class);
        // Set project details.
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->create_date = now();
        $project->finish_date = $request->finish_date;
        $project->created_by = Auth::user()->id;
        $project->project_coordinator = Auth::user()->id;
        $project->save();
  
        return redirect()->route('project', ['project_id' => $project->project_id])
            ->withSuccess('You have successfully created a new project!');
    }

    public function showCreateForm(): View
    {   
        return view('pages.createProject');
    }

    public function showProjectMembers(int $project_id) : View {
        
        $project = Project::find($project_id); 

        return view('pages.projectMembers', ['project'=> $project]);
        
    }

}
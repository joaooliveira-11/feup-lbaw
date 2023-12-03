<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Project_Users;
use Illuminate\Support\Facades\DB;

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

    public function showAllProjects() {
        $project = Project::where('is_public', true)->get();
        return view('pages.allProjects', ['projects'=>$project]);
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

    public function showCreateForm(): View {   
        return view('pages.createProject');
    }

    public function showProjects(): View {
        $projects = Project::where('is_public', true)->paginate(9);
        return view('pages.allProjects', ['projects'=>$projects]);
    }


    public function showProjectMembers(int $project_id) : View {
        $project = Project::find($project_id); 
        return view('pages.projectMembers', ['project'=> $project]);
    }

    public function showProjectTasks(int $project_id) : View {
        $project = Project::find($project_id); 
        return view('pages.allTasks', ['project'=> $project]);
    }

    public function search(Request $request)
    {
    $filter = strtolower($request->get('filter'));
    $page = $request->get('page');
    $projects = Project::whereRaw('LOWER(title) LIKE ?', ["%{$filter}%"])
                        ->where("is_public", true)
                        ->paginate(9, ['*'], 'page', $page);

    return response()->json([
        'projects' => $projects->items(),
        'currentPage' => $projects->currentPage(),
        'lastPage' => $projects->lastPage(),
        'hasMorePages' => $projects->hasMorePages(),
        'previousPageUrl' => $projects->previousPageUrl(),
        'nextPageUrl' => $projects->nextPageUrl(),
    ]);
}

    public function showNonProjectMembers(int $project_id) : View {
        $project = Project::find($project_id); 
        return view('pages.addUser', ['project'=> $project]);
    }

    public function addUser(Request $request) {   

        $project_users = new Project_Users();
        $project_users->project_id = $request->input('project_id');
        $project_users->user_id = $request->input('user_id');
        $project_id = $project_users->project_id;
        $project = Project::find($project_id); 

        $this->authorize('adduser', $project);

        $project_users->save();

        return view('pages.projectMembers', ['project'=> $project]);
    }
}
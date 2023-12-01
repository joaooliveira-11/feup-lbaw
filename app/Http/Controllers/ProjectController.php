<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Project_Users;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request) {   

        $this->authorize('create', Project::class);
        
        $validator = Validator::make($request->all(), [
            'title' => 'min:15|string|max:50',
            'description' => 'min:100|string|max:300',
            'finish_date' => 'nullable|date|after:now',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('createproject')
                ->withErrors($validator)
                ->withInput();
        }

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

    public function show(int $project_id) : View {

        $project = Project::find($project_id); 
        $this->authorize('show', $project);

        return view('pages.project', ['project'=>$project]);
    }

    public function showAllProjects() : View {
        $user = User::find(Auth::user()->id);
        $projectsQuery = Project::get_all_projects($user);
        $projects = $projectsQuery->paginate(9); 
    
        return view('pages.allProjects', ['projects' => $projects]);
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
        $projects = Project::whereRaw('LOWER(title) LIKE ?', ["%{$filter}%"])->where("is_public", true)->get();

        return response()->json($projects);
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
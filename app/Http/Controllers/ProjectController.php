<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Project_Users;
use App\Models\Invite;
use Illuminate\Support\Facades\DB;
use App\Events\AcceptedProjectInvite;

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

    public function createInvite(Request $request) {   

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

        return response()->json([
            'success' => 'Project created successfully!',
        ]);
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

    public function addMember(Request $request){
        $request->validate([
            'reference_id' => 'required|integer',
            'member_id' => 'required|integer',
        ]);

        event (new AcceptedProjectInvite());
        $invite = Invite::find($request->get('reference_id'));
        $project = Project::find($invite->project_invite);
        $member = User::find($request->get('member_id'));
        
        DB::table('project_users')->insert([
            'project_id' => $project->project_id,
            'user_id' => $member->id,
        ]);

        return response()->json([
            'members' => $project->members(), 
            'success' => 'Member added successfully!',
        ]);
        
    }

    public function leaveProject($id){
        
        $project = Project::find($id);
        $user = User::find(Auth::user()->id);

        Project_Users::where('project_id', $project->project_id)
                    ->where('user_id', $user->id)
                    ->delete();

        return response()->json([
            'success' => 'You left the project successfully!',
        ]);
    }

    public function kickMember($user_id, $project_id){
            
            $project = Project::find($project_id);
            $user = User::find($user_id);
    
            Project_Users::where('project_id', $project->project_id)
                        ->where('user_id', $user->id)
                        ->delete();
    
            return response()->json([
                'success' => 'User kicked from project successfully!',
            ]);
    }

    public function changeCoordinator($username, $project_id){
        
        
        $project = Project::find($project_id);
        $coordinator = User::where('username', $username)->first();

        $this->kickMember($coordinator->id, $project_id);

        $project->project_coordinator = $coordinator->id;
        
        $project->save();
        
        return response()->json([
            'success' => 'Coordinator changed successfully!',
        ]);
    }
    
    
}
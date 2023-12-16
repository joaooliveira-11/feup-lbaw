<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Project_Users;
use App\Models\Invite;
use App\Models\Favorite_Projects;
use Illuminate\Support\Facades\DB;
use App\Events\AcceptedProjectInvite;

class ProjectController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function show(int $id){

        $project = Project::find($id);  
        $this->authorize('show', $project);
        return view('pages.project', ['project'=>$project]);
    }

    public function showAllProjects() {
        $project = Project::where('is_public', true)->get();
        return view('pages.allProjects', ['projects'=>$project]);
    }

    public function create(Request $request) {   

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
    }

    public function updatedetails(Request $request){

        $project_id = $request->project_id;
        $project = Project::find($project_id);

        $this->authorize('updatedetails', $project); 

        $project->title = $request->title;
        $project->description = $request->description;
        $project->finish_date = $request->finish_date;

        $project->save();
        
        return response()->json([
            'project_title' => $project->title,
            'project_description' => $project->description,
            'project_finish_date' => $project->finish_date,
        ]);
    }

    public function showCreateForm(): View {   
        return view('pages.createProject');
    }

    public function showProjects(): View {
        $projects = Project::where('is_public', true)->paginate(9);
        return view('pages.allProjects', ['projects'=>$projects]);
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
    
    public function favoriteProject(Request $request){

        $project = Project::find($request->get('projectId'));
        $user = User::find($request->get('userId'));
        
        $favorite = Favorite_Projects::where('project_id', $project->project_id)
                             ->where('user_id', $user->id)
                             ->first();
        
        //delete if already favorited
        if ($favorite) {
            Favorite_Projects::where('project_id', $project->project_id)
                 ->where('user_id', $user->id)
                 ->delete();

            $favoritesCount = $project->favorites()->count();

            return response()->json([
                'success' => 'Project unfavorited successfully!',
                'favoritesCount' => $favoritesCount,
                'job' => 'remove',
            ]);
        }

        $favorite = new Favorite_Projects;
        $favorite->project_id = $project->project_id;
        $favorite->user_id = $user->id;
        $favorite->save();
        
        $favoritesCount = $project->favorites()->count();

        return response()->json([
            'success' => 'Project favorited successfully!',
            'favoritesCount' => $favoritesCount,
            'job' => 'add',
        ]);
    }

    public function update_visibility(Request $request, $id){
        $project = Project::find($id);
        $project->is_public = $request->input('is_public');
        $project->save();
        return response()->json([
            'message' => 'Project visibility updated successfully',
            'is_public' => $project->is_public,
        ]);
    }

    public function update_status(Request $request, $id){
        $project = Project::find($id);
        $project->archived = $request->input('archived');
        $project->save();
        return response()->json([
            'message' => 'Project status updated successfully',
            'archived' => $project->archived,
        ]);
    }
    
}

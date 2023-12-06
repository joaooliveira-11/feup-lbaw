<?php
namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Interest;
use App\Models\Skill;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display profile info.
     */
    public function show(int $id){
        $user = User::find($id);
        $interests = $user->interests()->get();
        $skills = $user->skills()->get();
        //$workerprojects = $user->workerProjects()->get();
        //$coordinatorprojects = $user->coordinatorProjects()->get();
        $projects = $user->projects();

        if(!$user)
            return redirect()->route('home')
                ->withError('User not found!');

        return view('profile.show', [
            'user' => $user,
            'interests' => $interests,
            'skills' => $skills,
            'projects' => $projects,
        ]);
    }

    /**
     * Display a profile edit form.
     */
    public function edit(int $id)
    {
        $user = User::find($id);
        $userInterests = $user->interests()->pluck('interest.interest_id')->toArray();
        $userSkills = $user->skills()->pluck('skill.skill_id')->toArray();

        $allInterests = Interest::getAllInterests();
        $allSkills = Skill::getAllSkills();

        if(!$user)
            return redirect()->route('home')
                ->withError('User not found!');

        return view('profile.edit', [
            'user' => $user,
            'userInterests' => $userInterests,
            'userSkills' => $userSkills,
            'allInterests' => $allInterests,
            'allSkills' => $allSkills
        ]);
    }  


    
    /**
     * Update a profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|max:12',
            'email' => 'required|email|max:250|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->description = $request->description;
        $user->save();
        
        $user->interests()->sync( $request->interests);
        $user->skills()->sync( $request->skills);


        return redirect()->route('show', $user->id)
            ->withSuccess('You have successfully updated your profile!');
    }

    public function name(Request $request){
        $id = $request->get('id');
        $name= User::find($id);

        return response()->json($name);
    }


    public function updateImage(Request $request) {
        $user = Auth::user();
        
        $request->validate([
            'profilePic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $this->authorize('update', $user);
    
        $file = $request->file('profilePic');
        $extension = $file->getClientOriginalExtension();
        $imageName = "user" . $user->id . "." . $extension;
        
        $path = public_path('profilePics/') . $imageName;
        if(file_exists($path)) {
            unlink($path);
        }
    
        $file->move(public_path('profilePics/'), $imageName);
    
        $user->photo = 'profilePics/' . $imageName;
        $user->save();
    
        return redirect("profile/".$user->id );
    }
    
}
?>

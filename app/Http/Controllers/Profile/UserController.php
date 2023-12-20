<?php
namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use App\Models\User;
use App\Models\Project_Users;
use App\Models\Interest;
use App\Models\Skill;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
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
            'username' => 'required|string|max:12|unique:users,username,' . $user->id,
            'email' => 'required|email|max:20|unique:users,email,' . $user->id,
        ]);

        if ($request->current_password && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $request->validate([
            'current_password' => ['nullable', 'required_with:new_password,new_password_confirmation'],
            'new_password' => ['nullable', 'required_with:current_password,new_password_confirmation', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->description = $request->description;

        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
        }

        
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

    public function deleteUser(int $id) {
        $user = User::find($id);

        Project_Users::where('user_id', $user->id)
        ->delete();

        $user->skills()->detach();
        $user->interests()->detach();


        $deletedName = 'deletedUser' . $user->id;
        $deletedUsername = 'deletedUser_' . $user->id;
        $deletedEmail = 'deletedUser_' . $user->id . '@email.com';
        $deletedDescription = 'This user has been deleted';
       
       
        $currentImage = public_path('profilePics/') . $user->photo;
        if (file_exists($currentImage)) {
            unlink($currentImage);
        }
        

        $user->name = $deletedName;
        $user->username = $deletedUsername;
        $user->email = $deletedEmail;
        $user->description = $deletedDescription;
        $user->photo = 'profilePics/user_default.jpg';

        $user->save();

        return redirect()->back();
    }
    
}
?>

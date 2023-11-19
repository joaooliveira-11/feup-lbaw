<?php
namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display profile info.
     */
    public function show(int $id)
    {
        $user = User::find($id);
        $interests = $user->interests()->get();
        $skills = $user->skills()->get();
        $projects = $user->projects()->get();

        if(!$user)
            return redirect()->route('home')
                ->withError('User not found!');

        return view('profile.show', [
            'user' => $user,
            'interests' => $interests,
            'skills' => $skills,
            'projects' => $projects
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

        $user->update($request->all());

        return redirect()->route('profile')
            ->withSuccess('You have successfully updated your profile!');
    }
}
?>

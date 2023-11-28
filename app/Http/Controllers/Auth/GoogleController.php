<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle() {

        $google_user = Socialite::driver('google')->stateless()->user();
        $user = User::where('google_id', $google_user->getId())->first();
        if (!$user) {
            $new_user = User::create([
                'name' => $google_user->getName(),
                'username' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'google_id' => $google_user->getId(),
            ]);

            Auth::login($new_user);
        } else {
            Auth::login($user);
        }

        $user_id = Auth::user()->id;
            return redirect()->route('show', ['id' => $user->id])
            ->withSuccess('You have successfully logged in!');
    }
}


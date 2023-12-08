<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/profile/' . Auth::id() );
        } else {
            return view('auth.login');
        }
    }


    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->is_banned) {
            return back()->withErrors([
                'email' => 'Your account is banned.'
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('show', ['id' => $user->id])
                ->withSuccess('You have successfully logged in!');
        }
        Alert::error('Error', 'Invalid credentials!');
        return back()->withInput($request->only('email'));
    }


    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 
}

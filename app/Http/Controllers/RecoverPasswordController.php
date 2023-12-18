<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;

class RecoverPasswordController extends Controller {
  public function show() {
    return view('auth.forgotPassword');
  }

  public function request(Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
      $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
      Alert::success('Success', 'We have e-mailed your password reset link!');
      return back();
    } else {
      Alert::error('Error', 'Invalid credentials!');
      return back()->withErrors(['email' => __($status)]);
    }
  }

  public function showRecover(Request $request) {
    return view('auth.resetPassword', ['token' => $request->token]);
  }

  public function recover(Request $request) {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) use ($request) {
        $user->forceFill([
          'password' => Hash::make($password)
        ]);

        $user->save();

        event(new PasswordReset($user));
      }
    );

    if ($status == Password::PASSWORD_RESET) {
      redirect()->route('login');
    } else {
      Alert::error('Error', 'Invalid password!');
      return back()->withErrors(['email' => __($status)]);
    }
  }
}
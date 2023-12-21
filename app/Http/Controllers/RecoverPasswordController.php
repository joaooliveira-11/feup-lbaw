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

    $status = Password::sendResetLink($request->only('email'));

    if ($status === Password::RESET_LINK_SENT) {
      Alert::success('Success', 'We have e-mailed your password reset link!');
      return back();
    } elseif ($status === Password::INVALID_USER) {
        Alert::error('Error', 'No account found with that email address.');
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
    $request->validate($this->passwordResetValidationRules());

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
            event(new PasswordReset($user));
        }
    );

    if ($status == Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('status', 'Your password has been reset. You can now login with your new password.');
    } else {
        Alert::error('Error', 'Invalid password!');
        return back()->withErrors(['email' => __($status)]);
    }
  }

  private function validationRules() {
      return ['email' => 'required|email'];
  }

  private function passwordResetValidationRules() {
      return [
          'token' => 'required',
          'email' => 'required|email',
          'password' => 'required|min:8|confirmed',
      ];
  }
}
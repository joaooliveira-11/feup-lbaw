<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class RecoverPasswordController extends Controller {
    public function show() {
        return view('auth.forgotPassword');
    }

    public function request(Request $request) {
      $request->validate(['email' => 'required|email']);
  
      $status = Password::sendResetLink(
        $request->only('email')
      );
  
      return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status), 'message' => 'Email sent to recover password!'])
        : back()->withErrors(['email' => __($status)]);
    }

    public function showRecoverPage(Request $request) {
      return view('auth.recoverPassword', ['token' => $request->token]);
    }
  
}

?>
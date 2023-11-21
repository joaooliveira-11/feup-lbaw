@extends('layouts.app')

@section('content')
<div id="login_page_content">
  <div id=login_background>
      <img src="{{ url('/img/login_background.png') }}" id="main_image"/>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
  </div>
  <div id="signin_content">
      <h1>Register Your Account</h1>
      <h2>Join our community and unlock exclusive benefits</h2>
      <form class="form-group" method="POST" action="{{ route('register') }}" required autofocus>
          {{ csrf_field() }}
          
          <div class="form-content mb-3">
              <input type="text" class="form-box" id="name" name="name" value="{{ old('name') }}" required placeholder="Name">
          </div>
          @if ($errors->has('name'))
              <span class="error">
                  {{ $errors->first('name') }}
              </span>
          @endif

          <div class="form-content mb-3">
              <input type="text" class="form-box" id="username" name="username" value="{{ old('username') }}" required placeholder="Username">
          </div>
          @if ($errors->has('username'))
              <span class="error">
                  {{ $errors->first('username') }}
              </span>
          @endif

          <div class="form-content mb-3">
              <input type="email" class="form-box" id="email" name="email" value="{{ old('email') }}" required placeholder="Email">
          </div>
          @if ($errors->has('email'))
              <span class="error">
                  {{ $errors->first('email') }}
              </span>
          @endif

          <div class="form-content mb-3">
              <input type="password" class="form-box" id="password" name="password" required placeholder="Password">
          </div>
          @if ($errors->has('password'))
              <span class="error">
                  {{ $errors->first('password') }}
              </span>
          @endif

          <div class="form-content mb-3">
                <input type="password" class="form-box" id="password-confirm" name="password_confirmation" required placeholder="Confirm Password">
            </div>

          <div id="butons_signin">
              <button type="submit" id="RegisterButton">Register</button>
          </div>
        </form>
        <div id="register-mobile">
            <span class="span-space">Already have an account?</span><a id="register-mobile-link" href="{{ route('login') }}">Log In</a>
        </div>
  </div>
</div>
@endsection
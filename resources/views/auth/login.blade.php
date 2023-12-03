@extends('layouts.app')

@section('content')
<div id="login_page_content">
    <div id="signin_content">
        <h1>Login to Your Account</h1>
        <h2>Login Using Social Networks </h2>
        <img src="{{ url('/img/gmail.png') }}" id="gmail_image" alt="Gmail Image"/>
        <span class="separator-text">or</span>
        <form class="form-group" method="POST" action="{{ route('login') }}" required autofocus>
            
        {{ csrf_field() }}
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
            <div id="butons_signin">
                <button type="submit" id="LoginButton">Sign In</button>
                <a id="forgot-password-link" href="{{ route('password.reset') }}">Forgot password?</a>
            </div>
            
            <div id="register-mobile">
                <span class="span-space">Don't have an account yet?</span><a id="register-mobile-link" href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>
    <div id=login_background>
        <img src="{{ url('/img/login_background.png') }}" id="main_image"/>
        <a class="button button-outline" href="{{ route('register') }}">Register</a>
    </div>
</div>
@endsection
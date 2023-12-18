@extends('layouts.app')

@section('content')

<div id="password-recovery-container">
    <h2 id="password-recovery-title">Password Recovery</h2>
    <p>Enter the email address associated with your account, and we'll send you a link to reset your password.</p>
    
    <div class="password-recovery-group">
      <input type="email" id="password-recovery-email" placeholder="Email">
    </div>

    <div class="password-recovery-group">
      <button id="password-recovery-submit">Continue</button>
    </div>
    
    <div id="password-recovery-footer">
      Don't have an account? <a class="password-recovery-link" href="#">Sign up</a>
    </div>
</div>


@endsection
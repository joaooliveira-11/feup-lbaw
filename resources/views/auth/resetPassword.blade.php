@extends('layouts.app')

@section('content')
<div class="password-recovery-container">
    <div class="logo-container">
        <img src="{{ asset('img/TeamSync.svg') }}" alt="logo">
    </div>

    <div class="recovery-content">
        <h2>Recover Password</h2>
        <p class="instruction-text">Enter a new password for your account!</p>

        <form method="POST" action="{{ route('password.recover') }}" class="recovery-form">
            @csrf
            <input type="hidden" value="{{ $token }}" name="token">

            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" id="inputEmail" name="email" required>
            </div>

            <div class="form-group" id="inputPasswordSection">
                <label for="inputPassword">New Password</label>
                <input type="password" id="inputPassword" name="password" required>
            </div>

            <div class="form-group" id="inputPasswordSection">
                <label for="inputPasswordConfirmation">New Password Confirmation</label>
                <input type="password" id="inputPasswordConfirmation" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Recover Password</button>
            </div>
        </form>
    </div>
</div>
@endsection

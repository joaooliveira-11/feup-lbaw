@extends('layouts.app')

@section('content')
<div class="password-recovery-container">
    <div class="logo-container">
        <img src="{{ asset('img/TeamSync.svg') }}" alt="logo">
    </div>

    <div class="recovery-content">
        <h2>Forgot Password</h2>
        <p class="instruction-text">No worries, We'll send you instructs for reset.</p>

        <form method="POST" action="{{ route('password.forgot') }}" class="recovery-form">
            @csrf
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required autofocus>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Recover Password</button>
                <button type="button" onclick="location.href='{{ route('login') }}';" class="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

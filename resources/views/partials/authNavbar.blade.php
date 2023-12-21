@section('authNavbar')

<div id="index-navbar">
    <img class="navbar-img" src="{{ asset('img/TeamSync_white.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="navbar-list-ul">
            <li><a class="navbar-list-element" href="{{ url('/index') }}">Landing</a></li>
            <li><a class="navbar-list-element" href="{{ url('/about') }}">About</a></li>
            <li><a class="navbar-list-element" href="{{ url('/faqs') }}">FAQs</a></li>   
        </ul>
    </div>
    <div class="navbar-profile-logout-notifications">
        <a class="navbar-login-button" href="{{ url('/login') }}">Log In</a>
        <span class="navbar-separator">|</span>
        <a class="navbar-register-button" href="{{ url('/register') }}">Sign Up</a>
    </div>  
</div>

@endsection
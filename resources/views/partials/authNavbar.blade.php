@section('authNavbar')

<div id="index-navbar">

    <img class="navbar-img" src="{{ asset('img/TeamSync_white.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="authnavbar-list-ul">
            <li><a class="authnavbar-list-element" href="">Home</a></li>
            <li><a class="authnavbar-list-element" href="">About</a></li>
            <li><a class="authnavbar-list-element" href="">FAQs</a></li>   
        </ul>
    </div>
    <div class="navbar-auth">
        @if (Auth::check())
            <a class="navbar-logout-button" href="{{ url('/logout') }}">Logout</a>
        @else
            <a class="navbar-login-button" href="{{ url('/login') }}">Log In</a>
            <span class="navbar-separator">|</span>
            <a class="navbar-register-button" href="{{ url('/register') }}">Sign Up</a>
        @endif

    </div>

</div>

@endsection
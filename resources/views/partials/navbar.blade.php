@section('navbar')
<div class="navbar">
    <img src="{{ asset('img/TeamSync.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="navbar-list-ul">
            <li><a class="navbar-list-element" href="#home">Home</a></li>
            <li><a class="navbar-list-element" href="#about">About</a></li>
            <li><a class="navbar-list-element" href="#faqs">FAQs</a></li>
            <li><a class="navbar-list-element" href="#projects">Projects</a></li>
            <li><a class="navbar-list-element" href="#profile">Profile</a></li>
         </ul>
    </div>
    <div class="navbar-logout">
        @if (Auth::check())
            <a class="navbar-logout-button" href="{{ url('/logout') }}"> Logout </a>
        @endif
    </div>

</div>
@endsection
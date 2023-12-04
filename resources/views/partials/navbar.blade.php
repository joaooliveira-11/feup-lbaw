@section('navbar')
<div class="navbar">
    <img src="{{ asset('img/TeamSync.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="navbar-list-ul">
        <li><a class="navbar-list-element" href="">Home</a></li>
            <li><a class="navbar-list-element" href="">About</a></li>
            <li><a class="navbar-list-element" href="">FAQs</a></li>
            <li><a class="navbar-list-element" href="{{ url('/projects') }}">Projects</a></li>
            <li>
                @if (Auth::check())
                    <a class="navbar-list-element" href="{{ url('/profile', ['id' => Auth::id()]) }}">Profile</a>
                @endif
            </li>
            

        </ul>
    </div>
    <div class="navbar-logout">
        @if (Auth::check())
            <a class="navbar-logout-button" href="{{ url('/logout') }}"> Logout </a>
        @endif
    </div>
    <button id = "notifications-button" >N</button> 
        <ul id ="notifications-dropdown" >
            @if (Auth::check() )
                @foreach ($notifications as $notification)
                    <div>{{ $notification->type }}</div>
                @endforeach
            @endif
            <li>Notification 1</li>
            <li>Notification 2</li>
            <li>Notification 3</li>
        </ul>

</div>
@endsection

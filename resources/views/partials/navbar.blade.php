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
    <button id = "notifications-button" ><i class="fa-solid fa-bell"></i></button>
        <div id = "notifications-dropdown">
            <div>
                <h1 id = "notifications-title">Notifications</h1>
                <button class = "dismiss-all-notis" onclick = "dismissAll()">All</button>
            </div>
            <ul id ="notifications-list" >
                @if (Auth::check() )
                    @foreach ($notifications as $notification)
                        @if ($notification->viewed == false)
                            @switch($notification->type)
                                @case('invite')
                                    <li class = "notification" id="n{{ $notification->notification_id}}">
                                            <p class="notification-text">You have been invited to join the project</p>
                                            <button class = "invite-accept" onclick = 'accept_invite({{ $notification->invite->project_invite }} , {{ $notification->notification_id }} , {{ $notification->emited_to }})'><i class="fa-solid fa-check"></i></button>
                                            <button class = "notification-deny" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-ban"></i></i></button>
                                    </li>
                                    @break
                                @case('comment')
                                    <li class = "notification" id="n{{ $notification->notification_id}}">
                                            <p class="notification-text">You have a new comment in the project</p>
                                            <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></button>
                                    </li>
                                    @break
                                @case('task')
                                    <li class = "notification" id="n{{ $notification->notification_id}}">
                                            <p class="notification-text">You have a new task in the project</p>
                                            <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'>X</button>
                                    </li>
                                    @break
                                @case('acceptedinvite')
                                    <li class = "notification" id="n{{ $notification->notification_id}}">
                                            <p class="notification-text">Your invite to the project has been accepted</p>
                                            <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></i></button>
                                    </li>
                                    @break
                                @default
                                    <li class = "notification" id="n{{ $notification->notification_id}}">
                                            <p class="notification-text">You have a new notification in the project</p>
                                    </li>
                            @endswitch
                        @endif
                    @endforeach
                @endif
                
            </ul>
        </div>
</div>
@endsection

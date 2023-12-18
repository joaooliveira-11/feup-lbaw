@section('navbar')
<script>
    var userId = "{{ Auth::check() ? Auth::id() : 'null' }}";
</script>
<div class="navbar">
    <img src="{{ asset('img/TeamSync.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="navbar-list-ul">
            <li><a class="navbar-list-element" href="">Home</a></li>
            <li><a class="navbar-list-element" href="#about-wrapper">About</a></li>
            <li><a class="navbar-list-element" href="">FAQs</a></li>
            <li><a class="navbar-list-element" href="{{ url('/projects') }}">Projects</a></li>
        </ul>
    </div>

    <div class="navbar-profile-logout-notifications">
        @if (Auth::check())
            <a class="navbar-list-element" href="{{ url('/profile', ['id' => Auth::id()]) }}">Profile</a>

            <a class="navbar-logout-button" href="{{ url('/logout') }}"> Logout </a>
        @endif
    <button id="notifications-button" ><i class="fa-solid fa-bell"></i><span id = "new-notification"></span></button>
    <div id="notifications-dropdown">
        <div>
            <h1 id="notifications-title">Notifications</h1>
            <button class="dismiss-all-notis" onclick = "dismissAll()"><i class="fa-solid fa-eye"></i>All</button>
        </div>
        <ul id ="notifications-list" >
            @if (Auth::check() )
                @foreach ($notifications as $notification)
                @switch($notification->type)
                        @case('invite')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have been invited to join the project</p>
                                    <button class = "invite-accept" onclick = 'accept_invite({{ $notification->invite->project_invite }} , {{ $notification->notification_id }} , {{ $notification->emited_to }})'><i class="fa-solid fa-check"></i></button>
                                    <button class = "notification-deny" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-ban"></i></button>
                            </li>
                            @break
                        @case('comment')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have a new comment in the task</p>
                                    <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></i></button>
                            </li>
                            @break
                        @case('task')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have a new task in the project.</p>
                                    <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></i></button>
                            </li>
                            @break
                        @case('acceptedinvite')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">Your invite to the project has been accepted.</p>
                                    <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></i></button>
                            </li>
                            @break
                        @case('forum')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">New message in the project chat.</p>
                                    <button class = "notification-dismiss" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-eye"></i></button>
                            </li>
                            @break
                        @default
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have a new notification {{$notification->type}}</p>
                            </li>
                    @endswitch
                @endforeach
            @endif
            
        </ul>
    </div>
    </div>
</div>
@endsection

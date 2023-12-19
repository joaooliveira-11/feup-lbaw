@section('navbar')
<script>
    var userId = "{{ Auth::check() ? Auth::id() : 'null' }}";
</script>
<nav class="hamnavbar">
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>
    <img src="{{ asset('img/TeamSync.svg') }}" alt="TeamSync">
    <div class="navbar-list">
        <ul class="navbar-list-ul">
            <li><a class="navbar-list-element" href="">Home</a></li>
            <li><a class="navbar-list-element" href="{{ url('/about') }}">About</a></li>
            <li><a class="navbar-list-element" href="">FAQs</a></li>
            <li><a class="navbar-list-element" href="{{ url('/projects') }}">Projects</a></li>
        </ul>
    </div>

    <div class="navbar-profile-logout-notifications">
        @if (Auth::check())
            <a class="navbar-profile-link" href="{{ url('/profile', ['id' => Auth::id()]) }}">
                <div class="user-avatar-circle">
                    <img src="{{ asset(Auth::user()->photo) }}" alt="User Profile" >
                </div>
            </a>
            <button id="notifications-button"><i class="fa-solid fa-bell"></i><span id="new-notification"></span></button>
            <a class="navbar-logout-button" href="{{ url('/logout') }}">
                <i class="fa fa-sign-out-alt"></i>
            </a>       
            @endif

    <div id="notifications-dropdown">
            <button class="close-notifications"><i class="fa-solid fa-times"></i></button>
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
                                    <button class = "invite-accept" onclick = 'accept_invite({{ $notification->reference_id }} , {{ $notification->notification_id }} , {{ $notification->emited_to }})'><i class="fa-solid fa-check"></i></button>
                                    <button class = "notification-deny" onclick = 'dismiss_notification({{ $notification->notification_id}})'><i class="fa-solid fa-ban"></i></button>
                            </li>
                            @break
                        @case('comment')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have a new comment on the task.</p>
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
                        @case('assignedtask')
                            <li class = "notification" id="n{{ $notification->notification_id}}">
                                    <p class="notification-text">You have been assigned to a task.</p>
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
</nav>
@endsection

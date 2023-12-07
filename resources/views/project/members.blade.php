@section('projectMembers')       
<div id="Members">
    <div class="add-user-title">
        <h3 class="add-user-title">Project Members</h3>
    </div>
    <div class="add-user-list">
        <ul class="add-user-ul">
            @foreach($project->members() as $user)
                @if(!$user->is_banned)
                    <a href="{{ route('show', ['id' => $user->id]) }}">
                        <li class="add-user-element">
                            <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                        </li>
                    </a>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="banned-user-title">
        <h3 class="banned-user-title">Banned Members:</h3>
    </div>
    <div class="banned-user-list">
        <ul class="banned-user-ul">
            @foreach($project->members() as $user)
                @if($user->is_banned)
                    <li class="banned-user-element">
                        <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>    
@endsection

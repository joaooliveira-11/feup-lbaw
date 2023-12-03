

@section('projectMembers')       
<div id="Members">
    <div class="add-user-title">
        <h3 class="add-user-title">Project Members</h3>
    </div>
    <div class="add-user-list">
        <ul class="add-user-ul">
            @foreach($project->users as $user)
            <a href="{{ route('show', ['id' => $user->id]) }}">
                <li class="add-user-element">
                    <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                </li>
            </a>
            @endforeach
        </ul>
    </div>
</div>    

@endsection
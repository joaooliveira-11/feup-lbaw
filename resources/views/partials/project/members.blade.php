 <div id="Members">
    <h3 class="project-members-title">Project Members</h3>
    <div class="project-members-content">
        <ul class="project-members-ul">
            @foreach($project->members() as $user)
                @if($user->id != $project->project_coordinator)
                    <a href="{{ route('show', ['id' => $user->id]) }}" class="container">
                        <li class="row project-member">
                            <p id="user{{ $user->id}}" class="user-id @if ( $user->id == $project->project_coordinator)coordinator-kick @endif" >{{ $user->name }} - <em>{{ '@' . $user->username }}</em> </p>
                        </li>
                    </a>
                @endif
            @endforeach
        </ul>
    </div>

    @if($project->members()->where('is_banned', true)->count() > 0)
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
    @endif
</div>    

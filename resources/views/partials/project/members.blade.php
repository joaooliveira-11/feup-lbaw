<div id="Members" class="container">
    <h3 class="project-members-title">Project Coordinator</h3>
    <div class="container project-members-content">
        @foreach($project->members() as $user)
            @if($user->id == $project->project_coordinator)
                <ul style="width: 20em;">
                    <a href="{{ route('show', ['id' => $user->id]) }}" style="text-decoration: none;">
                        <li class="row project-member">
                        <p id="user{{ $user->id}}">{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                        </li>
                    </a>
                </ul>
            @endif
        @endforeach
        <h3 class="project-members-title-2">Project Members</h3>
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
</div>    

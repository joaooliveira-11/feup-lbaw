<div id="Members">
    <div class="add-user-title">
        <h3 class="add-user-title">Project Members</h3>
    </div>
    <div class="add-user-list">
        <ul class="add-user-ul">
            @foreach($project->members() as $user)
                @if(!$user->is_banned)
                <a href="{{ route('show', ['id' => $user->id]) }}">
                    <li class="project-member">
                        <p id="user{{ $user->id}}" class= "user-id @if ( $user->id == $project->project_coordinator)coordinator-kick @endif" >{{ $user->name }} - <em>{{ '@' . $user->username }}</em> 
                        @if (Auth::user()->id == $project->project_coordinator)
                            <button class="kick-member" ><i class="fa-solid fa-user-xmark"></i></button>
                            </p>
                        @else
                        </p>
                        @endif
                        @if($user->id == $project->project_coordinator) 
                        <p id="coordinator-tag">Coordinator</p>
                        @endif
                    </li>
                </a>
                @endif
            @endforeach
        </ul>
        <button type="button" id="AddMemberModalButton" class="dashboard-project-button">Add Member</button>
        @include('modal.add_member', ['project' => $project])
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

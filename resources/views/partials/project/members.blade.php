 <div id="Members">
    <h3 class="project-members-title">Project Members</h3>
    <div class="project-members-content">
        <ul class="project-members-ul">
            @foreach($project->members() as $user)
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
            @endforeach
        </ul>
        <button type="button" id="AddMemberModalButton" class="dashboard-project-button">Add Member</button>
        @include('modal.add_member', ['project' => $project])
    </div>
</div>    


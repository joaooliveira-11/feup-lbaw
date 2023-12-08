 <div id="Members">
    <h3 class="project-members-title">Project Members</h3>
    <div class="project-members-content">
        <ul class="project-members-ul">
            @foreach($project->members() as $user)
            <a href="{{ route('show', ['id' => $user->id]) }}">
                <li class="project-member">
                    <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                </li>
            </a>
            @endforeach
        </ul>
        <button type="button" id="AddMemberModalButton" class="dashboard-project-button">Add Member</button>
        @include('modal.add_member', ['project' => $project])
    </div>
</div>    


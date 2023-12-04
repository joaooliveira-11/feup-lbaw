 <div id="Members">
    <div class="add-user-title">
        <h3 class="add-user-title">Project Members</h3>
    </div>
    <div class="add-user-list">
        <ul class="add-user-ul">
            @foreach($project->members() as $user)
            <a href="{{ route('show', ['id' => $user->id]) }}">
                <li class="add-user-element">
                    <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                </li>
            </a>
            @endforeach
        </ul>
        <button type="button" id= "AddMemberModalButton" > Add Member</button>
        @include('modal.add_member', ['project' => $project])
    </div>
</div>    


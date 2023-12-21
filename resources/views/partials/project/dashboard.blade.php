
<div id="Dashboard" class="selected">
    <div class="container dashboard-content">
        <div class="dashboard-left">
            <div id="ProjectDeadline" class="container">
                <h2 class="dashboard-project-title">Project Deadline:</h2>
                <p id="dashboard-project-content">{{ $project->finish_date !== null ? $project->finish_date : 'Not defined' }}</p>
            </div>
            <div id="MembersCounter" class="container">
                <h2 class="dashboard-project-title">Members:</h2>
                <p id="dashboard-project-content"> {{ $project->members()->count() }} </p>
            </div>
            <div id="ActiveTasks" class="container">
                <h2 class="dashboard-project-title">Total Tasks:</h2>
                <p id="dashboard-project-content"> {{ $project->tasks->count() }} </p>
            </div>
            <div id="Favorites" class="container">
                <h2 class="dashboard-project-title">Favorites: </h2>
                <p id="dashboard-project-content"> {{ $project->favorites()->count() }} </p>
                <button id="favorite-btn" onclick = "favoriteProject({{auth()->user()->id}})">
                    @if($project->is_favorite(auth()->user()))
                        <i class="fa-solid fa-heart"></i>
                    @else
                        <i class="fa-regular fa-heart"></i>
                    @endif
                </button>
            </div>
            <div class="dashboard-project-buttons">
                @if($project->is_member(auth()->user()))
                    <button type="button" id="CreateTaskModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}">Create Task</button>
                    @include('modal.create_task', ['project_id' => $project->project_id])
                @endif
                @if($project->is_coordinator(auth()->user()))
                    <button type="button" id="AddMemberModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}"> Invite Member</button>
                    @include('modal.add_member', ['project' => $project])
                    <button type="button" id="EditProjectModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}">Manage Details</button>
                    @include('modal.edit_proj', ['project' => $project])
                    <button type="button" id="AssignCoordinatorModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}">Assign Coordinator</button>
                    @include('modal.assign_coordinator', ['project' => $project])
                @endif
            </div>
        </div>
        <div id="ProjectDescription">
            <h2 class="dashboard-project-title">Description:</h2>
            <p id="dashboard-project-content">{{ $project->description }}</p>
            <div class="private-archived">
                <div>
                    <span>Private</span>
                    <label class="switch" data-project-id="{{ $project->project_id }}">
                        <input type="checkbox" id="visibilitySwitch" {{ !($project->is_public) ? 'checked' : '' }} {{ (Auth::user()->id !== $project->project_coordinator) ? 'disabled' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
                <div>
                    <span>Archived</span>
                    <label class="switch" data-project-id="{{ $project->project_id }}">
                        <input type="checkbox" id="statusSwitch" {{ $project->archived ? 'checked' : '' }} {{ (Auth::user()->id !== $project->project_coordinator) ? 'disabled' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

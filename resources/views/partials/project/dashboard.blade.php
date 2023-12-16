<div id="Dashboard" class="selected">
    <div class="dashboard-content">
        <div class="dashboard-left">
            <div id="ProjectDeadline">
                <h2 class="dashboard-project-title">Project Deadline:</h2>
                <p id="dashboard-project-content">{{ $project->finish_date !== null ? $project->finish_date : 'Not defined' }}</p>
            </div>
            <div id="MembersCounter">
                <h2 class="dashboard-project-title">Members:</h2>
                <p id="dashboard-project-content"> {{ $project->members()->count() }} </p>
            </div>
            <div id="ActiveTasks">
                <h2 class="dashboard-project-title">Active Tasks:</h2>
                <p id="dashboard-project-content"> {{ $project->tasks->count() }} </p>
            </div>
            <div id="Favorites">
                <h2 class="dashboard-project-title">Favorites: </h2>
                <p id="dashboard-project-content"> {{ $project->favorites()->count() }} </p>
                <button id = "favorite-btn" onclick = "favoriteProject({{auth()->user()->id}})">
                    @if($project->is_favorite(auth()->user()))
                        <i class="fa-solid fa-heart"></i>
                    @else
                        <i class="fa-regular fa-heart"></i>
                    @endif
                </button>
            </div>
            <div class="dashboard-project-buttons">
                @if($project->is_coordinator(auth()->user()))
                    <button type="button" id="AddMemberModalButton" class="dashboard-project-button"> Add Member</button>
                    @include('modal.add_member', ['project' => $project])
                @endif
                <button type="button" id="CreateTaskModalButton" class="dashboard-project-button">Create Task</button>
                @include('modal.create_task', ['project_id' => $project->project_id])
                @if($project->is_coordinator(auth()->user()))
                    <button type="button" id="EditProjectModalButton" class="dashboard-project-button">Manage Details</button>
                    @include('modal.edit_proj', ['project' => $project])
                @endif
            </div>
        </div>
        <div id="ProjectDescription">
            <h2 class="dashboard-project-title">Description:</h2>
            <p id="dashboard-project-content">{{ $project->description }}</p>
        </div>
    </div>
</div>

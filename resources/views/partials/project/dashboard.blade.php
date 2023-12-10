<div id="Dashboard" class="selected">
    <div class="dashboard-content">
        <div class="dashboard-left">
            <div id="ProjectDeadline">
                <h2 id="dashboard-project-title">Project Deadline:</h2>
                <p id="dashboard-project-content">{{ $project->finish_date !== null ? $project->finish_date : 'Not defined' }}</p>
            </div>
            <div id="MembersCounter">
                <h2 id="dashboard-project-title">Members:</h2>
                <p id="dashboard-project-content"> {{ $project->members()->count() }} </p>
            </div>
            <div id="ActiveTasks">
                <h2 id="dashboard-project-title">Active Tasks:</h2>
                <p id="dashboard-project-content"> {{ $project->tasks->count() }} </p>
            </div>
            <div id="UserTasks">
                <h2 id="dashboard-project-title">My Tasks:</h2>
                <!-- not implemented in create task -->
                @foreach ($project->tasks as $task)
                    @if ($task->user_id == auth()->user()->id)
                        <p id="dashboard-project-content">{{ $task->name }}</p>
                    @endif
                @endforeach
            </div>
            <div id="dashboard-project-buttons">
                @if($project->is_coordinator(auth()->user()))
                    <button type="button" id="AddMemberModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}"> Add Member</button>
                    @include('modal.add_member', ['project' => $project])
                @endif
                <button type="button" id="CreateTaskModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}">Create Task</button>
                @include('modal.create_task', ['project_id' => $project->project_id])
                @if($project->is_coordinator(auth()->user()))
                    <button type="button" id="EditProjectModalButton" class="dashboard-project-button {{ $project->archived ? 'archived-btn' : '' }}">Manage Details</button>
                    @include('modal.edit_proj', ['project' => $project])
                @endif
            </div>
        </div>
        <div id="ProjectDescription">
            <h2 id="dashboard-project-title">Description:</h2>
            <p id="dashboard-project-content">{{ $project->description }}</p>
        </div>
        <div>
            <span>Private</span>
            <label class="switch" data-project-id="{{ $project->project_id }}">
                <input type="checkbox" id="visibilitySwitch" {{ !($project->is_public) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
        <div>
            <span>Archived</span>
            <label class="switch" data-project-id="{{ $project->project_id }}">
                <input type="checkbox" id="statusSwitch" {{ $project->archived ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

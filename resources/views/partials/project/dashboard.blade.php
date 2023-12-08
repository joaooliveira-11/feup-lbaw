<div id="Dashboard" class="selected">
    <div class="dashboard-content">
        <div class="dashboard-left">
            <div id="ProjectDeadline">
                <h2 id="dashboard-project-title">Project Deadline:</h2>
                <p id="dashboard-project-content">{{ $project->deadline !== null ? $project->deadline : 'Not defined' }}</p>
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
                <button type="button" id="AddMemberModalButton" class="dashboard-project-button"> Add Member</button>
                @include('modal.add_member', ['project' => $project])
                <button type="button" id="CreateTaskModalButton" class="dashboard-project-button">Create Task</button>
                @include('modal.create_task', ['project_id' => $project->project_id])
            </div>
        </div>
        <div id="ProjectDescription">
            <h2 id="dashboard-project-title">Description:</h2>
            <p id="dashboard-project-content">{{ $project->description }}</p>
        </div>
    </div>
</div>

@section ('projectDashboard')
<div id = "Dashboard" class = "selected">
    <div id="ProjectDeadline">
        <h2 id="projectTitle">Project Deadline:</h2>
        <p>{{ $project->deadline !== null ? $project->deadline : 'Not defined' }}</p>
    </div>
    <div id="ProjectDescription">
        <h2>Description:</h2>
        <p>{{ $project->description }}</p>
    </div>
    <div id = "MembersCounter">
        <h2>Members:</h2>
        <p> {{ $project->members()->count() }} </p>
    </div>
    <div id = "ActiveTasks">
        <h2>Active Tasks:</h2>
        <p> {{ $project->tasks->count() }} </p>
    </div>
    <div id = "UserTasks">
        <h2>My Tasks:</h2>
        /* not implemented in create task */
        @foreach ($project->tasks as $task)
            @if ($task->user_id == auth()->user()->id)
                <p>{{ $task->name }}</p>
            @endif
        @endforeach
    </div>
    <div id = "TasksDashboard">
        <a id="CreateTaskButton" href="{{ route('createtaskform', ['project_id' => $project->project_id]) }}">Create Task</a>
        <a id="AddUserButton" href="{{ route('nonprojectmembers', ['project_id' => $project->project_id]) }}">Add member</a>
    </div>
    
</div>

@endsection
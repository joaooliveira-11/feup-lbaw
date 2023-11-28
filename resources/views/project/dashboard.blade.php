@section ('projectDashboard')
<div id = "Dashboard" class = "selected">
    <div id="ProjectDeadline">
        <p id="TitleInPage">Project Deadline:</p>
        <p>{{ $project->deadline !== null ? $project->deadline : 'Not defined' }}</p>
        <a id="CreateTaskButton" href="{{ route('createtaskform', ['project_id' => $project->project_id]) }}">Create Task</a>
        <a id="AddUserButton" href="{{ route('nonprojectmembers', ['project_id' => $project->project_id]) }}">Add member</a>
    </div>
    <div id="ProjectDescription">
        <p id="TitleInPage">Details:</p>
        <p>{{ $project->description }}</p>
    </div>
</div>

@endsection
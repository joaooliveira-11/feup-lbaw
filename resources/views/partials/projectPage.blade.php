@section('projectPage')

<div id="MainContent">
    <div id="ProjectDeadline">
        <p id="TitleInPage">Project Deadline:</p>
        <p>{{ $project->finish_date !== null ? $project->finish_date : 'Not defined' }}</p>
        <a id="AddUserButton" href="{{ route('nonprojectmembers', ['project_id' => $project->project_id]) }}">Add member</a>
    </div>
    <div id="ProjectDescription">
        <p id="TitleInPage">Details:</p>
        <p>{{ $project->description }}</p>
    </div>
    <div id="Tasks">
        <div class="line-before-tasks"></div>
        <p class="TaskLabel">Tasks:</p>
        @if($project->tasks->count() > 0)
            <ul id="TasksList">
                @foreach($project->tasks->take(4) as $task)
                    <a href="{{ url('task/' . $task->task_id )}}" class="project-link">
                        <li>
                            <div>
                                <p id="TaskTitle">{{ $task->title }}</p>
                                <p>{{ $task->description }}</p>
                                <p class="FinishDate">Deadline: {{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
                            </div>
                        </li> 
                    </a>
                @endforeach
            </ul>

            <div class="text-right">
                @if($project->tasks->count() > 4)
                    <a href="{{ url('view-all-tasks/' . $project->id) }}" class="btn btn-primary">View All</a>
                @endif
            </div>
        @else
            <p>No tasks found for this project.</p>
        @endif
    </div>
</div>
@endsection
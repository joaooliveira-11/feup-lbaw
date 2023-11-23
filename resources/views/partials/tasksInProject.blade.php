@section('tasksInProject')

<div id="Tasks">
    <p class="TaskLabel">All Tasks:</p>

    <div class="search-bar">
        <input type="text" id="taskSearch" placeholder="Search tasks..." oninput="searchTasks()">
        <button onclick="searchTasks()">Search</button>
    </div>
    <div id="tasks-container" class= "{{$project->project_id}}">
    @if($project->tasks->count() > 0)
        <ul class="TasksList">
            @foreach($project->tasks as $task)
                <a href="{{ url('task/' . $task->task_id )}}" class="project-link task-link">
                    <li>
                        <div>
                            <p class="TaskTitle">{{ $task->title }}</p>
                            <p>{{ $task->description }}</p>
                            <p class="FinishDate">Deadline: {{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
                        </div>
                    </li> 
                </a>
            @endforeach
        </ul>
        </div>
    @else
        <p>No tasks found for this project.</p>
    @endif
</div>

@endsection

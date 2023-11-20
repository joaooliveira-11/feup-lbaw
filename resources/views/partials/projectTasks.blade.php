@section('projectTasks')

<div id="Tasks">
    <div class="line-before-tasks"></div>
    <p class="TaskLabel">Tasks:</p>
    @if($project->tasks->count() > 0)
        <ul id="TasksList">
            @foreach($project->tasks as $task)
            <a href="{{ url('task/' . $task->task_id )}}" class="project-link">
                <li>
                    <div>
                        <p id="TaskTitle">{{ $task->title }}</p>
                        <p>{{ $task->description }}</p>
                        <p class="FinishDate">Deadline: {{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
                    </div>
                </li> 
            @endforeach
        </ul>
    @else
    <p>No tasks found for this project.</p>
    @endif
</div>

@endsection
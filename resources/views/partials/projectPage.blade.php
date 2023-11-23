@section('projectPage')

<div id="MainContent">
    <div id="ProjectDeadline">
        <p id="TitleInPage">Project Deadline:</p>
        <p>{{ $project->finish_date !== null ? $project->finish_date : 'Not defined' }}</p>
        <a id="CreateTaskButton" href="{{ route('createtaskform', ['project_id' => $project->project_id]) }}">Create Task</a>
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

        <div id="taskContainer">
            <div id="createTask" style="display: none;">
                <form method="POST" action="{{ url('/task/create') }}" class="createTaskForm">
                <h4>New Task</h4>
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" id="title" required>
                @if($errors->has('title'))
                <div class="error">{{ $errors->first('title') }}</div>
                @endif

                <label for="description">Description:</label>
                <input type="text" name="description" class="form-control" id="description" required>
                @if($errors->has('description'))
                <div class="error">{{ $errors->first('description') }}</div>
                @endif

                <label for="finish_date">Finish Date:</label>
                <input type="date" name="finish_date" class="form-control" id="finish_date">
                @if($errors->has('finishdate'))
                <div class="error">{{ $errors->first('finishdate') }}</div>
                @endif

                <label for="priority">Priority:</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <button type="submit" class="btn btn-outline-dark" id="createTaskButton">Create Task</button>
                </form>
            </div>         
        </div>
    </div>
</div>

@endsection
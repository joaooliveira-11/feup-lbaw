<div id="Tasks">
    <div class="task-content">
        <h2 class="project-tasks-title">Tasks</h2>
        <div class="project-members-search-bar">
            <input type="text" id="taskSearch" class="members-searchbar"placeholder="Search tasks..." oninput="searchTasks()">
            <button class="search-users-button" onclick="searchTasks()">Search</button>
        </div>
        <div id="tasks-container" class= "{{$project->project_id}}">
            @if($project->tasks->count() > 0)
            <ul class="TasksList">
                @foreach($project->tasks as $task)
                    <a href="{{ url('task/' . $task->task_id )}}" class="project-link task-link">
                        <li>
                            <p class="TaskTitle">{{ $task->title }}</p>
                            <p>{{ $task->description }}</p>
                            <p class="FinishDate">Deadline: {{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
                        </li> 
                    </a>
                @endforeach
            </ul>
        </div>
        @else
            <p>No tasks found for this project.</p>
        @endif
    </div>
</div>


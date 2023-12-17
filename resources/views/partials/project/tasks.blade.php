<div id="Tasks" class="container">
    <div class="container task-content">
        <h2 class="row project-tasks-title">Tasks</h2>
        <div class="container project-members-search-bar">
            <input type="text" id="taskSearch" class="members-searchbar"placeholder="Search tasks..." oninput="searchTasks()">
            <button class="search-users-button" onclick="searchTasks()">Search</button>
            <form id = "status-filter">
                <label for="status-selected">Status:</label>
                <select id="status-selected" onchange="searchTasks()">
                    <option value="all">All</option>
                    <option value="open">Open</option>
                    <option value="assigned">Assigned</option>
                    <option value="closed">Closed</option>
                    <option value="archived">Archived</option>
                </select>
                <label for="priority-selected">Priority:</label>
                <select id="priority-selected" onchange="searchTasks()">
                    <option value="all">All</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </form>
        </div>
        <div id="tasks-container" class="container {{$project->project_id}}">
            @if($project->tasks->count() > 0)
            <ul class="TasksList">
                @foreach($project->tasks as $task)
                    <a href="{{ url('task/' . $task->task_id )}}" class="container project-link task-link">
                        <li>
                            <p class="row TaskTitle">{{ $task->title }}</p>
                            <p class="row">{{ $task->description }}</p>
                            <p class="row FinishDate">Deadline: {{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
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


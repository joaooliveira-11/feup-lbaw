@extends('layouts.app')
@section('title', $project->name)

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="Sidebar">
            <h1>{{ $project->title }}</h1> 
            <div class="title-line"></div>
            <a href="">Dashboard</a>
            <a href="">Chat</a>
            <a href=" ">Tasks</a>
            <a href="{{ route('projectmembers', ['project_id' => $project->project_id]) }}">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Project</a>
        </div>

        <div id="MainContent">
            <div id="ProjectDeadline">
                <p id="TitleInPage">Project Deadline:</p>
                <p>{{ $project->deadline !== null ? $project->deadline : 'Not defined' }}</p>
                <a id="CreateTaskButton" href="{{ route('createtaskform', ['project_id' => $project->project_id]) }}">Create Task</a>
                <a id="CreateTaskButton" href="">Add Member</a>
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
    </div>
</div>

@endsection

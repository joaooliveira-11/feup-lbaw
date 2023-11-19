@extends('layouts.app')
@section('title', $project->name)

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="Sidebar">
            <h1>{{ $project->title }}</h1> 
            <a href="">Dashboard</a>
            <a href="">Messages</a>
            <a href=" ">Tasks</a>
            <a href="">Members</a>
        </div>
        <div id="MainContent">
            <div id="Name">
                <p>{{ $project->title }}</p>
            </div>
            <div id="Description">
                <p>{{ $project->description }}</p>
            </div>
        
            <div id="Projects">
                <p class="label">Tasks</p>
                @if($project->tasks->count() > 0)
                    <ul id="ProjectsList">
                        @foreach($project->tasks as $task)
                            <li>
                                <div>
                                    <p id="ProjectTitle">{{ $task->name }}</p>
                                    <p>{{ $task->description }}</p>
                                </div>
                            </li> 
                        @endforeach
                    </ul>
                @else
                    <p>No tasks found for this project.</p>
                @endif
                <div id="taskContainer">
                    <button class="btn btn-primary" id="showCreateTaskBtn">Create Task</button>

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

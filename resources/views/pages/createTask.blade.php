@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="Sidebar">
            <h1>{{ $project_id }}</h1> 
            <div class="title-line"></div>
            <a href="">Dashboard</a>
            <a href="">Chat</a>
            <a href=" ">Tasks</a>
            <a href="">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Project</a>
        </div>

        <div id="createTask">
            <form method="POST" action="{{ route('createtask') }}" class="createTaskForm">
                <h4>New Task</h4>
                @csrf
                <input type="hidden" name="project_id" value="{{ $project_id }}">

                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" id="title" required>
                @if($errors->has('title'))
                <div class="error">{{ $errors->first('title') }}</div>
                @endif

                <label for="description">Description:</label>
                <textarea type="text" rows="4" col="55" name="description" class="form-control" id="description" required></textarea>
                @if($errors->has('description'))
                <div class="error">{{ $errors->first('description') }}</div>
                @endif

                <label for="finish_date">Finish Date:</label>
                <input type="date" name="finish_date" class="form-control" id="finish_date">
                @if($errors->has('finishdate'))
                <div class="error">{{ $errors->first('finishdate') }}</div>
                @endif

                <label for="priority">Priority:</label>
                <select name="priority" id="priority" class="form-control" required>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <button type="submit" class="btn btn-outline-dark" id="createTaskButton">Create Task</button>
            </form>
        </div>
    </div>
</div>

@endsection

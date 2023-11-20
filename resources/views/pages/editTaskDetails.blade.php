@extends('layouts.app')
@section('title', $task->title)

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="Sidebar">
            <h1>{{ $task->title }}</h1> 
            <div class="title-line"></div>
            <a href="">Dashboard</a>
            <a href="">Chat</a>
            <a href=" ">Tasks</a>
            <a href="">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Project</a>
        </div>
        <div class="edit-task-details">
            <form action="{{ route('updatetaskdetails') }}" method="POST">
                <h4>Edit Task Details</h4>
                
                @csrf
                @method('PATCH')
    
                <input type="hidden" name="task_id" value="{{ $task->task_id }}">
    
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $task->title }}" required>
    
                <label for="description">Description:</label>
                <textarea type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ $task->description }}</textarea>
    
                <label for="finish_date">Finish Date:</label>
                <input type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ \Carbon\Carbon::parse($task->finish_date)->format('Y-m-d\TH:i') }}">
    
                <label for="priority">Priority:</label>
                <select name="priority" id="priority" class="form-control" required>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                </select>
    
                <button type="submit" class="btn btn-outline-dark editTaskDetailsButton" id="createTaskButton">Update Details</button>
            </form>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')
@section('title', $task->name)

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        <div id="Sidebar">
            <h1>{{ $task->title }}</h1> 
            <div class="title-line"></div>
            <a href="">Dashboard</a>
            <a href="{{ url('project/' . $task->project_task )}}">Project</a>
            <a href=" ">Chat</a>
            <a href="">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Task</a>
        </div>

        <div id="TaskContent">
            <div class="task-details">
                <div id="TaskInfo">
                    <h5><span class="profile-info-span">Task: </span>{{ $task->title }}</h5>
                    <h5><span class="profile-info-span">Deadline: </span>{{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</h5>
                    <h5><span class="profile-info-span">Priority: </span>{{ $task->priority }}</h5>
                    <a id="EditTaskDetailsButton" href="{{ route('editDetailsForm', ['task_id' => $task->task_id]) }}">Manage Details</a>
                </div>
                <div id="Description">
                    <h5 class = "label">Details</h5>
                    <p>{{ $task->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

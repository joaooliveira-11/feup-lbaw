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

        <div id="MainContent">
            <div id="ProjectDeadline">
                <p id="TitleInPage">Task Deadline:</p>
                <p>{{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</p>
                <button id="CreateTaskButton">Invite User</button>
            </div>
            <div id="ProjectDescription">
                <p id="TitleInPage">Details:</p>
                <p>{{ $task->description }}</p>
            </div>
        </div>
    </div>
</div>

@endsection

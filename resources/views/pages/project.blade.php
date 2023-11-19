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
                <button id="CreateTaskButton">Create Task</button>
                <button id="CreateTaskButton">Invite User</button>
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
            </div>
        </div>
    </div>
</div>

@endsection

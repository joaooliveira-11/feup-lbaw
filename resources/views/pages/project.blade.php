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
                <a href="{{ url('/task/create', ['project_id' => $project->project_id]) }}" class="btn btn-primary">Create Task</a>
            </div>
        </div>
    </div>
</div>

@endsection

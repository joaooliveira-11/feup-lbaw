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

        @include('partials.projectPage')
        @yield('projectPage')
    </div>
</div>

@endsection

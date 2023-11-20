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
            <a href="">Tasks</a>
            <a href="">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Project</a>
        </div>
        
        @include('partials.createTaskForm')
        @yield('createTaskForm')
    </div>
</div>

@endsection

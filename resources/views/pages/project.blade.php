@extends('layouts.app')

@include('project.dashboard')
@include('project.members')
@include('project.chat')
@include('project.tasks')
@include('project.sidebar')

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        @yield('projectSidebar')
        <div id="MainContent">
        @yield('projectDashboard')
        @yield('projectMembers')
        @yield('projectChat')
        @yield('tasks')
        </div>
    </div>
</div>
@endsection

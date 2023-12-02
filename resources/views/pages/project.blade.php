@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProjectInfo">
        @include('project.sidebar')
        <div id="MainContent">
        @include('project.dashboard')
        @include('project.members')
        @include('project.chat')
        @include('project.tasks')
        </div>
    </div>
</div>
@endsection

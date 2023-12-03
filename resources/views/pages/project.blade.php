@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProjectInfo">
        @include('partials.project.sidebar')
        <div id="MainContent">
        @include('partials.project.dashboard')
        @include('partials.project.members')
        @include('partials.project.chat')
        @include('partials.project.tasks')
        </div>
    </div>
</div>
@endsection

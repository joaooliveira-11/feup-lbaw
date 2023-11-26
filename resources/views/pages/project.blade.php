@extends('layouts.app')

@section('content')

<div id="ProjectPage">
    <div id="ProjectInfo">
        @include('partials.projectSidebar')
        @yield('projectSidebar')
        @include('partials.projectPage')
        @yield('projectPage')
    </div>
</div>

@endsection

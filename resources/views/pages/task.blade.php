@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProjectInfo" class="task-page-wrapper">
        @include('partials.task.details')
        @include('partials.task.comments')
    </div>
</div>
@endsection
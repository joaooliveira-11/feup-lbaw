@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="TaskInfo">
        @include('partials.task.details')
        <!-- @include('partials.task.comments') -->
    </div>
</div>
@endsection
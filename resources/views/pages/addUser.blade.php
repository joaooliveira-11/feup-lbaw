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
            <a href="">Members</a>
            <a href="#" id="leaveProject" class="center-button">Leave Project</a>
        </div>
        
        <div id="project-members-content">

            <div class="add-user-title">
                <h3 class="add-user-title">Add Member</h3>
            </div>
            <div class="add-user-list">
                <ul class="add-user-ul">
                    @foreach($project->nonmembers()  as $user)
                        <li class="add-user-element">
                            <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                            <form method="POST" action="{{ route('adduser') }}">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-outline-dark add-user-button" id="createTaskButton">Add</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>    
    </div>
</div>

@endsection
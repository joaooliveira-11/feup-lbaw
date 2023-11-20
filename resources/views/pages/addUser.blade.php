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
                <h3 class="add-user-title">Non-Project Members</h3>
            </div>
            <div class="add-user-list">
                <ul class="add-user-ul">
                    @foreach($project->usersNotInProject()  as $user)
                        <li class="add-user-element">
                            <p>{{ $user->name }} - <em>{{ '@' . $user->username }}</em></p>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>    
    </div>
</div>

@endsection
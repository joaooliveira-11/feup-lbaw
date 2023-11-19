@extends('layouts.app')

@section('content')
<div id="profile_page_content">
    <h1>Hello, {{ $user->name}}</h1>
    <p>Here is your profile:</p>
    <div id="ProfilePicture">
    <img src="https://via.placeholder.com/150" alt="Profile Picture">
    </div>
    <div id = "profile_container">
        <div id = "ProfileInfo"> 
            <div id="Name" class = "label-info">
                <p class = "label">Name </p>
                <p> {{ $user->name }}</p>
            </div>
            <div id="Email" class = "label-info" >
                <p class = "label" >Email </p>
                <p>{{ $user->email }}</p>
            </div>
            <div id="Username" class = "label-info">
                <p class = "label">Username </p>
                <p> {{ $user->username }}</p>
            </div>
            <div id="Description" class = "label-info">
                <p class = "label">Description </p>
                <p>{{ $user->description }}</p>
            </div>
        </div>
        <div id = "Interests">
            <p class = "label">Interests</p>
            @if ($interests->isEmpty())
            <p>No interests yet!</p>
            @else
                @foreach ($interests as $interest)
                <li>{{ $interest->interest }}</li>
                @endforeach
            @endif
        </div>
        <div id = "Skills">
            <p class = "label">Skills</p>
            @if ($skills->isEmpty())
            <p>No skills yet!</p>
            @else
                @foreach ($skills as $skill)
                <li>{{ $skill->skill }}</li>
                @endforeach
            @endif
        </div>
        <div id = "Projects">
            <p class = "label">Projects</p>
            @if ($projects->isEmpty())
            <p>No projects yet!</p>
            @else
                @foreach ($projects as $project)
                <li>
                    <p id = "ProjectTitle">{{ $project -> title }} </p>
                    <p>{{ $project -> description }} </p>
                </li>
                @endforeach
            @endif
        </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div id="profile_page_content">
    <div id="ProfilePicture">
    <img src="https://via.placeholder.com/150" alt="Profile Picture">
    </div>
        <div id = "ProfileInfo"> 
            <div id="Name">
                <p> {{ $user->name }}</p>
            </div>
            <div id="Username">
                <p>( {{ $user->username }} )</p>
            </div>
            <div id="Email" >

                <p> Contact: {{ $user->email }}</p>
            </div>
            
            <div id="Description">
                <p class = "label">About me </p>
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
            <ul id = "ProjectsList">
                @foreach ($projects as $project)
                <li>
                    <p id = "ProjectTitle">{{ $project -> title }} </p>
                    <p>{{ $project -> description }} </p>
                </li>
                @endforeach
            @endif
        </div>
    </div>
@endsection

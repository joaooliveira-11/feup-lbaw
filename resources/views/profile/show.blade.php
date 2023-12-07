@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProfilePage">
        <div class="Profile-LeftSection">
            <label for="fileInput">
                <img id="profilePicture" src="https://via.placeholder.com/150" alt="Profile Picture" style="cursor: pointer;">
                <input id="fileInput" type="file">
            </label>           
            <div class="profile-interests-skills">
                <div id="Interests">
                    <h4 class="interests-title">Interests</h4>
                    @if ($interests->isEmpty())
                    <p>No interests yet!</p>
                    @else
                        @foreach ($interests as $interest)
                        <p>{{ $interest->interest }}</p>
                        @endforeach
                    @endif
                </div>
                <div id="Skills">
                    <h4 class="skills-title">Skills</h4>
                    @if ($skills->isEmpty())
                    <p>No skills yet!</p>
                    @else
                        @foreach ($skills as $skill)
                        <p>{{ $skill->skill }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="Profile-RightSection">
            <div id="ProfileInfo"> 
                <div class="profile-right-section-left">
                    <h5><span class="profile-info-span">Name: </span>{{ $user->name }}</h5>
                    <h5><span class="profile-info-span">Username: </span><em>{{$user->username}}</em></h5>
                    <h5><span class="profile-info-span">Email: </span>{{ $user->email }}</h5>
                    <div id="EditProfile">
                        <button onclick="location.href='{{ url("/edit-profile/".$user->id) }}'">Edit Profile</button>
                    </div>
                </div>
                
                <div id="Description">
                    <h5 class="profile-info-span">About me </h5>
                    <p>{{ $user->description }}</p>
                </div>
            </div>

            <div id="Projects">
            <h4 class="label">Projects</h4>

            @if ($projects->isEmpty())
                <p>No projects yet!</p>
            @else
                <ul id="ProjectsList">

                    @foreach ($projects as $project)
                        <a href="{{ url('project/' . $project->project_id )}}" class="project-link project-element">
                            <li>
                                <p id="ProjectTitle" class="project-list-title">{{ $project->title }}</p>
                                <p class="project-list-description">{{ $project->description }}</p>
                            </li> 
                        </a>
                    @endforeach

                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
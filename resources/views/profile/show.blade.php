@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProfilePage">
        <div class="Profile-LeftSection">
            <label for="fileInput">
                <img id="profilePicture" src="{{ asset(Auth::user()->photo) }}" alt="Profile Picture" style="cursor: pointer;">
                <form method="POST" action="{{ route('profile.updateImage') }}" enctype="multipart/form-data">
                    @csrf
                    <input id="fileInput" name="profilePic" type="file" data-update-url="{{route('profile.updateImage')}}">
                    <button type="submit">Upload Image</button>
                </form>
            </label>           
            <div class="profile-interests-skills">
                <div id="Interests">
                    <h4>Interests</h4>
                    @if ($interests->isEmpty())
                    <p>No interests yet!</p>
                    @else
                        @foreach ($interests as $interest)
                        <p>{{ $interest->interest }}</p>
                        @endforeach
                    @endif
                </div>
                <div id="Skills">
                    <h4>Skills</h4>
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
                    <h5 class = "label">About me </h5>
                    <p>{{ $user->description }}</p>
                </div>
            </div>

            <div id="Projects">
            <p class="label">Projects</p>

            @if ($projects->isEmpty())
                <p>No projects yet!</p>
            @else
                <ul id="ProjectsList">
                        @foreach ($projects as $project)
                            <a href="{{ url('project/' . $project->project_id )}}" class="project-link">
                                <li>
                                    <div>
                                        <p id="ProjectTitle">{{ $project->title }}</p>
                                        <p>{{ $project->description }}</p>
                                    </div>
                                </li> 
                            </a>
                        @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
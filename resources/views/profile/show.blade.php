@extends('layouts.app')

@section('content')
<div id="ProjectPage">
    <div id="ProfilePage" class="container">
        <div class="row">
            <div class="col-md-4 Profile-LeftSection">
                <div class="profile-photo-container">
                    <img id="profilePicture" src="{{ asset($user->photo) }}" alt="Profile Picture">
                    @if(Auth::check() && (Auth::user()->id == $user->id || Auth::user()->isAdmin()))
                        <label for="fileInput" class="edit-icon-label">
                            <div class="edit-icon-circle">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                        </label>
                        <form method="POST" action="{{ route('profile.updateImage') }}" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input id="fileInput" name="profilePic" type="file" onchange="this.form.submit()">
                        </form>
                    @endif
                </div>
                <div id="userActions">
                    <div id="banUserButton">
                    @if(Auth::check() && Auth::user()->isAdmin() && Auth::user()->id !== $user->id)
                        @if($user->is_banned)
                            <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">Unban User</button>
                            </form>
                        @else
                            <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Ban User</button>
                            </form>
                        @endif
                    @endif
                    </div>

                    <div id="deleteButton">
                    @if(Auth::check() && ((Auth::user()->isAdmin() && Auth::user()->id !== $user->id) || (!Auth::user()->isAdmin() && Auth::user()->id === $user->id)))
                        <form action="{{ route('deleteUser', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">Delete Account</button>
                        </form>
                    @endif
                    </div>
                </div>
                <div class="container row profile-interests-skills" style="margin:0 auto;">
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
                        <h4 class="interests-title">Skills</h4>
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

            <div class="col-md-8 Profile-RightSection">
                <div id="ProfileInfo" class="container"> 
                    <div class="row profile-right-section-left">
                        <h5><span class="profile-info-span">Name: </span>{{ $user->name }}</h5>
                        <h5><span class="profile-info-span">Username: </span><em>{{$user->username}}</em></h5>
                        <h5><span class="profile-info-span">Email: </span>{{ $user->email }}</h5>
                        @if(Auth::check() && (Auth::user()->id == $user->id || Auth::user()->isAdmin()))
                        <div id="EditProfile">
                            <button onclick="location.href='{{ url("/edit-profile/".$user->id) }}'">Edit Profile</button>
                        </div>
                        @endif
                    </div>
                    
                    <div id="Description" class="row">
                        <h5 class="profile-info-span">About me</h5>
                        <p>{{ $user->description }}</p>
                    </div>
                </div>
                @if(Auth::check() && !Auth::user()->isAdmin())
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
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
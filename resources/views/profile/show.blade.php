@extends('layouts.app')

@section('content')
<div id="profile_page_content">
    <h1>Profile</h1>
    <div id="ProfilePicture">
    <img src="https://via.placeholder.com/150" alt="Profile Picture">
    </div>
    <div id="Name">
        <p>Name: {{ $user->name }}</p>
    </div>
    <div id="Email">
        <p>Email: {{ $user->email }}</p>
    </div>
    <div id="Username">
        <p>Username: {{ $user->username }}</p>
    </div>
    <div id="Description">
        <p>Description: {{ $user->description }}</p>
    </div>
    <div id = "Interests">
        <p>Interests:</p>
        @if ($interests->isEmpty())
        <p>No interests yet!</p>
        @else
            @foreach ($interests as $interest)
            <p>{{ $interest->interest }}</p>
            @endforeach
        @endif
    </div>
    <div id = "Skills">
        <p>Skills:</p>
        @if ($skills->isEmpty())
        <p>No skills yet!</p>
        @else
            @foreach ($skills as $skill)
            <p>{{ $skill->skill }}</p>
            @endforeach
        @endif
</div>
@endsection

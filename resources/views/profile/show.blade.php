@extends('layouts.app')

@section('content')
<div id="profile_page_content">
    <h1>Profile</h1>
    <div id="Name">
        <p>Name: {{ $user->name }}</p>
    </div>
    <div id="Email">
        <p>Email: {{ $user->email }}</p>
    </div>
    <div id="Username">
        <p>Username: {{ $user->username }}</p>
    <div id="Description">
        <p>Description: {{ $user->description }}</p>
    </div>
    <div id = "Interests">
        <p>Interests:</p>
        @foreach ($interests as $interest)
        <p>{{ $interest->interest }}</p>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div id="profile_page_content">
    <h1>Profile</h1>
    <div id="Name">
        <p>Name : {{ $user->name }}</p>
    </div>
    <div id="Email">
        <p>{{ $user->email }}</p>
    </div>
    <!-- Add more fields as needed -->
</div>
@endsection

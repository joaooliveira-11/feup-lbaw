@extends('layouts.app')

@section('content')
<div id = "edit-page-content">
    <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ $user->username }}">

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50">{{ $user->description }}</textarea>

            <label for="interests">Interests:</label>
            @foreach($allInterests as $interest)
            <div>
                <input type="checkbox" id="{{ $interest->interest_id }}" name="interests[]" value="{{ $interest->interest_id }}" {{ in_array($interest->interest_id, $userInterests) ? 'checked' : '' }}>
                <label for="{{ $interest->interest_id }}">{{ $interest->interest }}</label>
            </div>
            @endforeach

            <label for="skills">Skills:</label>
            @foreach($allSkills as $skill)
            <div>
                <input type="checkbox" id="{{ $skill->skill_id }}" name="skills[]" value="{{ $skill->skill_id }}" {{ in_array($skill->skill_id, $userSkills) ? 'checked' : '' }}>
                <label for="{{ $skill->skill_id }}">{{ $skill->skill }}</label>
            </div>
            @endforeach

            <input type="submit" value="Update Profile">
        </form>
        
</div>

@endsection
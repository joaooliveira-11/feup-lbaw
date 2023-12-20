@extends('layouts.app')

@section('content')
<div id="ProfileDisplay">
    <div id="edit-page-content">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            @if($errors->has('name'))
                <div class="error">{{ $errors->first('name') }}</div>
            @endif

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}">
            @if($errors->has('username'))
                <div class="error">{{ $errors->first('username') }}</div>
            @endif

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
            @if($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50">{{ old('description', $user->description) }}</textarea>

            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password">
            @if($errors->has('current_password'))
                <div class="error">{{ $errors->first('current_password') }}</div>
            @endif

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">
            @if($errors->has('new_password'))
                <div class="error">{{ $errors->first('new_password') }}</div>
            @endif

            <label for="new_password_confirmation">Confirm New Password:</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation">
            @if($errors->has('new_password_confirmation'))
                <div class="error">{{ $errors->first('new_password_confirmation') }}</div>
            @endif
            
            <div id="interests">
                <label>Interests:</label>
                <div id="interests-list">
                    @foreach($allInterests as $interest)
                        <div class="interest {{ in_array($interest->interest_id, $userInterests) ? 'selected' : '' }}" >
                            <label>
                                <input type="checkbox" id="{{ $interest->interest_id }}" name="interests[]" value="{{ $interest->interest_id }}" {{ in_array($interest->interest_id, $userInterests) ? 'checked' : '' }}>
                                {{ $interest->interest }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="skills">
                <label>Skills:</label>
                <div id="skills-list">
                    @foreach($allSkills as $skill)
                        <div class="skill {{ in_array($skill->skill_id, $userSkills) ? 'selected' : '' }}" >
                            <label>
                                <input type="checkbox" id="skill{{ $skill->skill_id }}" name="skills[]" value="{{ $skill->skill_id }}" {{ in_array($skill->skill_id, $userSkills) ? 'checked' : '' }}>
                                {{ $skill->skill }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <input type="submit" value="Update Profile">
        </form>
    </div>
</div>
@endsection
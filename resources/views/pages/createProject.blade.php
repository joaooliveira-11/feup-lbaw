@extends('layouts.app')

@section('content')


<div id="ProjectPage">
  <div id="ProjectInfo">
    <div class="new-project-form">
      <form method="POST" action = "{{ url('/project/create') }}" class="createProjectForm">
        <h2>New Project</h2>
        @csrf
        <label for="title">Title:</label>
          <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
        @if($errors->has('title'))
        <div class="error">{{ $errors->first('title') }}</div>
        @endif
        <label for="description">Description:</label>
          <textarea name="description" class="form-description" id="description" required>{{ old('description') }}</textarea>
        @if($errors->has('description'))
        <div class="error">{{ $errors->first('description') }}</div>
        @endif
        <label for="finish_date">Finish Date:</label>
          <input type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ old('finish_date') }}">
        @if($errors->has('finish_date'))
        <div class="error">{{ $errors->first('finish_date') }}</div>
        @endif
        <button type="submit" class="btn btn-outline-dark" id="createProjectButton">Create Project</button>
      </form>
    </div>
  </div>
</div>

@endsection



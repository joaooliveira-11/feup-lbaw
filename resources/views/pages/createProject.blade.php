@extends('layouts.app')

@section('content')

<main>
<div id="createProject">
  <form method="POST" action = "{{ route('createproject') }}" class="createProjectForm">
  <h4>New Project</h4>
    @csrf
    <div class="form-group">
      <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
    </div>
    @if($errors->has('title'))
        <div class="error">{{ $errors->first('title') }}</div>
    @endif
    <div class="form-group">
      <input type="text" name="description" class="form-control" id="description" placeholder="Description" required>
    </div>
    @if($errors->has('description'))
        <div class="error">{{ $errors->first('description') }}</div>
    @endif
    <div class="form-group">
        <input type="date" name="finish_date" class="form-control" id="finish_date" placeholder="Finish Date">
    </div>
    @if($errors->has('finishdate'))
        <div class="error">{{ $errors->first('finishdate') }}</div>
    @endif
    <button type="submit" class="btn btn-outline-dark" id="createProjectButton">Create Project</button>
  </form>
</div>
</main>
@endsection
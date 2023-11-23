@section('createTaskForm')

<div id="createTask">
    <form method="POST" action="{{ route('createtask') }}" class="createTaskForm">
        <h4>New Task</h4>
        @csrf
        <input type="hidden" name="project_id" value="{{ $project_id }}">

        <label for="title">Title:</label>
        <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
        @if($errors->has('title'))
        <div class="error">{{ $errors->first('title') }}</div>
        @endif

        <label for="description">Description:</label>
        <textarea type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
        @if($errors->has('description'))
        <div class="error">{{ $errors->first('description') }}</div>
        @endif

        <label for="finish_date">Finish Date:</label>
        <input type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ old('finish_date') }}">
        @if($errors->has('finishdate'))
        <div class="error">{{ $errors->first('finish_date') }}</div>
        @endif

        <label for="priority">Priority:</label>
        <select name="priority" id="priority" class="form-control" required>
            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
        </select>
        @if($errors->has('priority'))
        <div class="error">{{ $errors->first('priority') }}</div>
        @endif

        <button type="submit" class="btn btn-outline-dark" id="createTaskButton">Create Task</button>
    </form>
</div>

@endsection
<div class="container task-left-section" id="Details">
    <div class="go-back-section">
        <a href="{{ route('project', ['project_id' => $task->project_task]) }}">
            <img src="{{ url('/img/back_arrow.svg') }}" id="back-arrow" alt="Back Arrow"/>
        </a>
        <h5>{{ $task->task_project->title }}</h5>
    </div>
    <div id="task-details" class="container">
        <h5><span class="task-info-span" id="task-details-title">Task: </span>{{ $task->title }}</h5>
        <h5><span class="task-info-span" id="task-details-finish_date">Deadline: </span>{{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</h5>
        <h5><span class="task-info-span" id="task-details-priority">Priority: </span>{{ $task->priority }}</h5>
        <h5><span class="task-info-span" id="task-details-assigned_to">Assigned: </span>{{ $task->assigned_to !== null ? $task->assigned_user->username : 'Not defined' }}</h5>
        <h5><span class="task-info-span" id="task-details-state">State: </span>{{ $task->state }}</h5>
        <h5 class="task-file-submit">
            <span class="task-info-span" style="margin: 0;" id="task-details-file">File: </span>
            {{ $task->file_path ? '1/1' : '0/1' }}
            @if($task->assigned_to == auth()->user()->id && ($task->state == 'assigned' || $task->state == 'completed'))
                <form action="{{ route('task.upload') }}" class="{{ $task->task_project->archived ? 'archived-btn' : '' }}" method="post" enctype="multipart/form-data" style="display: flex; align-items: center; margin-bottom: 0;">
                    <input type="hidden" name="task_id" value="{{ $task->task_id }}">
                    @method('PATCH')
                    @csrf
                    <input type="file" name="task_file" id="task_file" onchange="this.form.submit()" style="display: none;">
                    <label for="task_file" style="margin: 0;">
                        <img src="{{ url('/img/submit_task_file.svg') }}" alt="Upload File" style="cursor: pointer;">
                    </label>
                </form>
            @endif
        </h5>
        @if($task->file_path)
            <a href="{{ route('task.download', $task->task_id) }}">Download File</a>
        @endif
        <div class="task-details-buttons">
            @if($task->task_project->is_coordinator(auth()->user()))
                <button type="button" id="EditTaskModalButton" class="task-details-button {{ $task->task_project->archived ? 'archived-btn' : '' }}" onclick="toggleModal('editTaskModalWrapper')">Manage Details</button>
                <button type="button" class="task-details-button {{ $task->task_project->archived ? 'archived-btn' : '' }}" id="assignUserButton" onclick="toggleModal('assignTaskModalWrapper')">Assign User</button>
            @endif
            @if($task->assigned_to == auth()->user()->id && $task->state == ('assigned'))
                <button type="button" id="completetaskbtn" class="task-details-button {{ $task->task_project->archived ? 'archived-btn' : '' }}" data-task-id="{{ $task->task_id }}">Complete Task</button>
            @endif
            <button type="button" id="" class="task-details-button {{ $task->task_project->archived ? 'archived-btn' : '' }}" data-task-id="{{ $task->task_id }}">Archive Task</button>
            @if($task->task_project->is_coordinator(auth()->user()))
            <div id="assignTaskModalWrapper">
                @include('modal.assign_task', ['task' => $task])
            </div>
            <div id="editTaskModalWrapper">
                @include('modal.edit_task', ['task_id' => $task->task_id])
            </div>
            @endif
        </div>
        <div id="task-description" class="container">
            <h5 class="row">Details</h5>
            <p>{{ $task->description }}</p>
        </div>
    </div>
</div>




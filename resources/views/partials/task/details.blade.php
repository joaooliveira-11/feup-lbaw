<div class="task-left-section" id="Details">
    <div class="go-back-section">
        <img src="{{ url('/img/back_arrow.svg') }}" id="back-arrow" alt="Back Arrow"/>   <!-- falta meter clickable com redirect para tras-->
        <h5 href="">Nome do Projeto</a>
    </div>
    <div id="task-details">
        <h5><span class="task-info-span" id="task-details-title">Task: </span>{{ $task->title }}</h5>
        <h5><span class="task-info-span" id="task-details-finish_date">Deadline: </span>{{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</h5>
        <h5><span class="task-info-span" id="task-details-priority">Priority: </span>{{ $task->priority }}</h5>
        <h5><span class="task-info-span" id="task-details-assigned_to">Assigned: </span>{{ $task->assigned_to !== null ? $task->assigned_user->username : 'Not defined' }}</h5>
        <h5><span class="task-info-span" id="task-details-state">State: </span>{{ $task->state }}</h5>
        <div class="task-details-buttons">
            @if($task->task_project->is_coordinator(auth()->user()))
                <button type="button" id="EditTaskModalButton" class="task-details-button">Manage Details</button>
                @include('modal.edit_task', ['task_id' => $task->task_id])
            @endif
            @if($task->assigned_to == auth()->user()->id)
                <form action="{{ route('task.complete') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="task_id" value="{{ $task->task_id }}">
                    <button type="submit" id="EditTaskDetailsButton" class="task-details-button">Complete Task</button>
                </form>
            @endif
            <button type="button" class="btn btn-primary" id="assignUserButton">Assign User</button>
            @include('modal.assign_task', ['task' => $task])
        </div>
        <div id="task-description">
            <h5>Details</h5>
            <p>{{ $task->description }}</p>
        </div>
    </div>
</div>





<div class="task-left-section">
    <div class="go-back-section">
        <img src="{{ url('/img/back_arrow.svg') }}" id="back-arrow" alt="Back Arrow"/>   <!-- falta meter clickable com redirect para tras-->
        <h5 href="">Nome do Projeto</a>
    </div>
    <div id="task-details">
        <h5><span class="task-info-span">Task: </span>{{ $task->title }}</h5>
        <h5><span class="task-info-span">Deadline: </span>{{ $task->finish_date !== null ? $task->finish_date : 'Not defined' }}</h5>
        <h5><span class="task-info-span">Priority: </span>{{ $task->priority }}</h5>
        <h5><span class="task-info-span">Assigned: </span>{{ $task->assigned_to !== null ? $task->assigned_to : 'Not defined' }}</h5>
        <h5><span class="task-info-span">State: </span>{{ $task->state }}</h5>
        <div class="task-details-buttons">
            <button type="button" id="EditTaskModalButton" class="task-details-button">Manage Details</button>
            @include('modal.edit_task', ['task_id' => $task->task_id])
            <form action="{{ route('task.complete') }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="task_id" value="{{ $task->task_id }}">
                <button type="submit" id="EditTaskDetailsButton" class="task-details-button">Complete Task</button>
            </form>
        </div>
        <div id="task-description">
            <h5>Details</h5>
            <p>{{ $task->description }}</p>
        </div>
    </div>
</div>

<div id="comments">
    <div class="comments-section">
        <div class="comment">       <!-- estrutura de um comentario -->
            <img src="" alt="">     <!-- imagem do user -->
            <p></p>                 <!-- conteudo -->
        </div>
    </div>
    <form class="comment-form" action="{{ route('task.complete') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->task_id }}">
        <textarea name="" id="" placeholder="Type comment"></textarea>
        <button id="submit-comment-button" type="submit" id="SubmitComment">Send</button>
    </form>
</div>


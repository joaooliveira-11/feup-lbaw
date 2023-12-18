<form action="{{ route('task.assign') }}" id="assignTaskForm" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="task_id" id="task_id" value="{{ $task->task_id }}">
    <input type="hidden" name="assign_task_to" id="assign_task_to">
    <div class="modal fade text-left" id="ModalAssignTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Task</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @foreach($task->task_project->members() as $user)
                                <div class="assign_task_member" data-id="{{ $user->id }}">
                                    <img src="{{ url('/img/gmail.png') }}">
                                    <span>{{ $user->username }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success"> {{ __('Assign Task') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
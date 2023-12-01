<form action="{{route('task.update_details')}}" id="edittaskform" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="hidden" name="task_id" id="task_id" value="{{ $task_id }}">
    <div class="modal fade text-left" id="ModalEditTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Task Details') }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Title') }}:</strong>
                            <input type="text" name="title" class="form-control" id="title" required value="{{ $task->title }}">
                            <div class="error" id="titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Description') }}:</strong>
                            <textarea type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ $task->description  }}</textarea>
                            <div class="error" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Finish Date') }}:</strong>
                            <input type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ \Carbon\Carbon::parse($task->finish_date)->format('Y-m-d H:i') }}">
                            <div class="error" id="finish_dateError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Priority') }}:</strong>
                            <select name="priority" id="priority" class="form-control" required>
                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success" >{{ __('Save') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

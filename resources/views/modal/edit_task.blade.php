<form action="{{route('task.update_details')}}" id="edittaskform" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="hidden" name="task_id" id="task_id" value="{{ $task_id }}">
    <div class="modal fade text-left" id="ModalEditTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Task Details') }}</h4>
                    <button type="button" class="close modal-top-button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Title') }}:</strong>
                            <input type="text" name="title" class="form-control modal-simple-text" id="title" required value="{{ $task->title }}">
                            <div class="error" id="titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Description') }}:</strong>
                            <textarea type="text" rows="4" col="55" name="description" class="form-control modal-textarea" id="description" required>{{ $task->description  }}</textarea>
                            <div class="error" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Finish Date') }}:</strong>
                            <input type="datetime-local" name="finish_date" class="form-control modal-simple-text" id="finish_date" value="{{ optional($task->finish_date)->format('Y-m-d H:i') }}">
                            <div class="error" id="finish_dateError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Priority') }}:</strong>
                            <select name="priority" id="priority" class="form-control modal-simple-text" required>
                                <option class="modal-simple-text" value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option class="modal-simple-text" value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option class="modal-simple-text" value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success modal-bottom-button" >{{ __('Save') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

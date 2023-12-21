<form action="{{route('task.update_details')}}" id="edittaskform" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="hidden" name="task_id" id="task_id" value="{{ $task_id }}">
    <div class="modal fade text-left" id="ModalEditTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="font-size: 2rem; font-weight: 600;" class="modal-title">{{ __('Edit Task Details') }}</h4>
                    <button style="font-size: 2rem;" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Title') }}:</strong>
                            <input style="font-size: 1.4rem;" type="text" name="title" class="form-control" id="title" required value="{{ $task->title }}">
                            <div class="error" id="titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Description') }}:</strong>
                            <textarea style="resize: none; font-size: 1.4rem;" type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ $task->description  }}</textarea>
                            <div class="error" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Finish Date') }}:</strong>
                            <input style="font-size: 1.4rem;" type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ optional($task->finish_date)->format('Y-m-d H:i') }}">
                            <div class="error" id="finish_dateError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Priority') }}:</strong>
                            <select style="font-size: 1.4rem;" name="priority" id="priority" class="form-control" required>
                                <option style="font-size: 1.4rem;" value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option style="font-size: 1.4rem;" value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option style="font-size: 1.4rem;" value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button style="font-size: 1.6rem; font-weight: 600; width: 8em;" type="submit" class="btn btn-success" >{{ __('Save') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{route('createtask')}}" id="createtaskform"method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="project_id" id="project_task" value="{{ $project_id }}">
    <div class="modal fade text-left" id="ModalCreateTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Create New Task') }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Title') }}:</strong>
                            <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
                            <div class="error" id="titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Description') }}:</strong>
                            <textarea type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
                            <div class="error" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Finish Date') }}:</strong>
                            <input type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ old('finish_date') }}">
                            <div class="error" id="finish_dateError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('Priority') }}:</strong>
                            <select name="priority" id="priority" class="form-control" required>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
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

<form action="{{route('task.create')}}" id="createtaskform"method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="project_id" id="project_task" value="{{ $project_id }}">
    <div class="modal fade text-left" id="ModalCreateTask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="font-size: 2rem; font-weight: 600;" class="modal-title">{{ __('Create New Task') }}</h4>
                    <button style="font-size: 2rem;" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Title') }}:</strong>
                            <input style="font-size: 1.4rem;" type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
                            <div class="error" id="titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Description') }}:</strong>
                            <textarea style="resize: none; font-size: 1.4rem;" type="text" rows="4" col="55" name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
                            <div class="error" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Finish Date') }}:</strong>
                            <input style="font-size: 1.4rem;" type="datetime-local" name="finish_date" class="form-control" id="finish_date" value="{{ old('finish_date') }}">
                            <div class="error" id="finish_dateError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Priority') }}:</strong>
                            <select style="font-size: 1.4rem;" name="priority" id="priority" class="form-control" required>
                                <option style="font-size: 1.4rem;" value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option style="font-size: 1.4rem;" value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option style="font-size: 1.4rem;" value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
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

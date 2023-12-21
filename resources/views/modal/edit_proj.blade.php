<form action="{{route('project.update_details')}}" id="editprojectform" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="hidden" name="project_id" id="project_id" value="{{ $project->project_id }}">
    <div class="modal fade text-left" id="ModalEditProject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Project Details') }}</h4>
                    <button type="button" class="close modal-top-button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Title') }}:</strong>
                            <input type="text" name="title" class="form-control modal-simple-text" id="proj_title" required value="{{ $project->title }}">
                            <div class="error" id="proj_titleError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Description') }}:</strong>
                            <textarea type="text" rows="4" col="55" name="description" class="form-control modal-textarea" id="proj_description" required>{{ $project->description  }}</textarea>
                            <div class="error" id="proj_descriptionError"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Finish Date') }}:</strong>
                            <input type="datetime-local" name="finish_date" class="form-control modal-simple-text" id="proj_finish_date" value="{{ $project->finish_date ? \Carbon\Carbon::parse($project->finish_date)->format('Y-m-d\TH:i') : '' }}">
                            <div class="error" id="proj_finish_dateError"></div>
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
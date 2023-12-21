<form action="{{route('project.create')}}" id="createprojectform" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreateProject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Create Project') }}</h4>
                    <button type="button" class="close modal-top-button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-bottom">
                    <div class="modal-left">
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong class="modal-second-title">{{ __('Title') }}:</strong>
                                    <input type="text" name="title" class="form-control modal-simple-text" id="proj_title" required>
                                    <div class="error" id="proj_titleError"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong class="modal-second-title">{{ __('Description') }}:</strong>
                                    <textarea type="text" rows="4" col="55" name="description" class="form-control modal-textarea" id="proj_description" required></textarea>
                                    <div class="error" id="proj_descriptionError"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong class="modal-second-title">{{ __('Finish Date') }}:</strong>
                                    <input type="datetime-local" name="finish_date" class="form-control modal-simple-text" id="proj_finish_date">
                                    <div class="error" id="proj_finish_dateError"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-success modal-bottom-button" >{{ __('Save') }} </button>
                            </div>
                        </div>
                    </div>
                    <div class="contextual-help">
                        <div class="contextual-help-container">
                            <h3>Title:</h3>
                            <p>Between 15 and 50 characters</p>
                        </div>
                        <div class="contextual-help-container">
                            <h3>Description:</h3>
                            <p>Between 100 and 300 characters</p>
                        </div>
                        <div class="contextual-help-container">
                            <h3>Finish Date (Optional):</h3>
                            <p>Only a date in the future</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
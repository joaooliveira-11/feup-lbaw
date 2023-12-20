<form action="" id="assignCoordinatorForm" method="post">
    @csrf
    <input type="hidden" id="assign_coordinator" name="assign_coordinator">
    <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
    <div class="modal fade text-left" id="ModalAssignCoordinator" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Coordinator</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @foreach($project->members() as $user)
                                @if ($user->id != $project->project_coordinator)
                                    <div class="assign_coordinator_member" data-id="{{ $user->username }}">
                                        <img src="{{ url($user->photo) }}">
                                        <span>{{ $user->username }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success"> {{ __('Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
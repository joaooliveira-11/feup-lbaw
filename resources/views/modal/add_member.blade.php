<form action="{{ route('invite.create') }}" id="addmemberform" method="post">
    @csrf
    <input type="hidden" name="project_id" id="project_id" value="{{ $project->project_id }}">
    <div class="modal fade text-left" id="ModalAddMember" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Invite Member to Project') }}</h4>
                    <button class="modal-top-button" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="modal-second-title">{{ __('Member') }}:</strong>
                            <select name="member_id" id="member_id" class="form-control modal-simple-text" required>
                                @foreach($project->nonmembers() as $member)
                                    <option class="modal-simple-text" value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success modal-bottom-button"> {{ __('Invite to Project') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
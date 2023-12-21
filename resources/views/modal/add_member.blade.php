<form action="{{ route('invite.create') }}" id="addmemberform" method="post">
    @csrf
    <input type="hidden" name="project_id" id="project_id" value="{{ $project->project_id }}">
    <div class="modal fade text-left" id="ModalAddMember" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="font-size: 2rem; font-weight: 600;" class="modal-title">{{ __('Add Member to Project') }}</h4>
                    <button style="font-size: 2rem;" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong style="font-size: 1.6rem; font-weight: 600;">{{ __('Member') }}:</strong>
                            <select style="font-size: 1.4rem;" name="member_id" id="member_id" class="form-control" required>
                                @foreach($project->nonmembers() as $member)
                                    <option style="font-size: 1.4rem;" value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button style="font-size: 1.6rem; font-weight: 600; width: 12em; margin-top: 2rem;" type="submit" class="btn btn-success"> {{ __('Add to Project') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
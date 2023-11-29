<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Invite;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy{
    use HandlesAuthorization;

    public function create(User $user, Invite $invite) : bool {
        $project = Project::find($invite->project_invite);
        return $project->is_coordinator($user);
    }
    
}
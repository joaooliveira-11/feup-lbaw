<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy{
    use HandlesAuthorization;

    public function create(User $user) : bool {
        return !($user->isAdmin());
    }
    public function updatedetails(User $user, Project $project) : bool {
        return $project->is_coordinator($user);
    }

    public function show(User $user, Project $project) : bool {
        return $project->is_member($user) || $user->isAdmin() || $project->is_public;
    }

    public function delete(User $user, User $model) {
        return $user->id == $model->id;
    }

    public function adduser(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }

    public function kickmember(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }

    public function change_coordinator(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }

    public function update_visibility(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }

    public function update_status(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }
}
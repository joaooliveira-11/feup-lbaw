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

    public function show(User $user, Project $project) : bool {
        return $project->is_member($user) || $user->isAdmin() || $project->is_coordinator($user) || $project->is_public;
    }

    public function delete(User $user, User $model) {
        return $user->id == $model->id;
    }

    public function adduser(User $user, Project $project) : bool{
        return $project->is_coordinator($user);
    }
}
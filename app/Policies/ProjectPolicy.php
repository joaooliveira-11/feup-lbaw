<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Project $project) {
        return $project->is_member($user) || $user->isAdmin();
    }

    public function create(User $user){
        return !($user->isAdmin());
    }

    public function delete(User $user, User $model) {
        // Only a profile owner can delete it
        return $user->id == $model->id;
    }
}
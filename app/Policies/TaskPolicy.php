<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;

use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy {

    use HandlesAuthorization;

    public function show(User $user, Task $task): bool {
        $project = Project::find($task->project_task);
        return $project->is_member($user) || $user->isAdmin() || $project->is_coordinator($user);    
    }
    
    public function create(User $user, Task $task): bool {
        $project = Project::find($task->project_task);
        return $project->is_member($user) || $user->isAdmin() || $project->is_coordinator($user);    
    }

/*
    public function create(User $user, Project $project): bool {
        return $project->is_member($user) || $user->isAdmin() || $project->is_coordinator($user);
    }

    DUVIDA PORQUE NAO POSSO USAR ISTO
*/
}
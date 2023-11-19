<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class TaskPolicy {

    public function show(User $user, Task $task) {
        $project = Project::find($task->project_task);
        return $project->is_member($user) || $user->isAdmin();    
    }
    
    public function create(User $user, Task $task): bool {
        // User can only create tasks in projects they own.
        return $user->id === $task->project->user_id;
    }
}
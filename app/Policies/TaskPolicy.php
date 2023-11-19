<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class TaskPolicy {

    // User can only create tasks in projects they are members.
    public function create(User $user, Task $task): bool {
        return $user->id === $task->project->user_id;
    }
}
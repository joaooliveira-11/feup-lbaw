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
        return $project->is_member($user) || $project->is_coordinator($user);    
    }

    public function updatedetails(User $user, Task $task) : bool {
        $project = Project::find($task->project_task);
        return $project->is_member($user) || $project->is_coordinator($user);  
    }
    
    public function completetask(User $user, Task $task) : bool {
        return $task->assigned_to == $user->id;
    }

    public function archivetask(User $user, Task $task) : bool {
        $project = Project::find($task->project_task);
        return  $project->is_coordinator($user) && $task->state == 'completed';
    }

    public function assign(User $user, Task $task) : bool {
        $project = Project::find($task->project_task);
        return $project->is_coordinator($user);  
    }

    public function upload(User $user, Task $task) : bool {
        return $task->assigned_to == $user->id;
    }

    public function download(User $user, Task $task) : bool {
        $project = Project::find($task->project_task);
        return $project->is_member($user);
    }

}

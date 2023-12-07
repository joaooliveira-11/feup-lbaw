<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy{
    use HandlesAuthorization;

    public function create(User $user, Comment $comment) : bool {
        $task = Task::find($comment->task_comment);
        $project = Project::find($task->project_task);

        return (($project->is_member($user) || $project->is_coordinator($user)) && !($task->is_archived()) && $task->is_assigned());
    }
    
    public function delete(User $user, Comment $comment) : bool {
        $task = Task::find($comment->task_comment);
        $project = Project::find($task->project_task);

        return ($project->is_member($user)  && !($task->is_archived()) && $comment->comment_by == $user->id);
    }

}
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy{
    use HandlesAuthorization;

    public function create(User $user, Message $message) : bool {
        $project = Project::find($message->project_message);
        return $project->is_member($user) && !($project->archived);
    }
    
    public function delete(User $user, Message $message) : bool {
        $project = Project::find($message->project_message);

        return ($project->is_member($user) && !($project->archived) && $message->message_by == $user->id);
    }

    public function edit(User $user, Message $message) : bool {
        $project = Project::find($message->project_message);

        return ($project->is_member($user) && !($project->archived) && $message->message_by == $user->id);
    }
}
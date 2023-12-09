<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectInvite implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project_id;
    public $message;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($project_id, $user_id){
        $this->project_id = $project_id;
        $this->user_id = $user_id;
        $this->message = "You have been invited to join the project";
    }

    
    public function broadcastAs(){
        return 'notification-invite';
    }

    public function broadcastOn(){
        return 'notifications';
    }
}
?>

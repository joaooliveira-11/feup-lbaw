<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcceptedProjectInvite  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $coordinator;
    /**
     * Create a new event instance.
     */
    public function __construct(){
        $this->message = "Your invite to join the project has been accepted!";
    }

    
    public function broadcastAs(){
        return 'accepted-invite';
    }

    public function broadcastOn(){
        return 'notifications';
    }
}

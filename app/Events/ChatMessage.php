<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $message_id;
    public $message_by;
    public $create_date;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $message_id, $message_by, $create_date){
        $this->message = $message;
        $this->message_id = $message_id;
        $this->message_by = $message_by;
        $this->create_date = $create_date;
    }

    
    public function broadcastAs(){
        return 'chat-message';
    }

    public function broadcastOn(){
        return 'chat';
    }
}

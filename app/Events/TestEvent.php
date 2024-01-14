<?php

namespace App\Events;

use App\Models\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventName;
    public $userId;
    /**
     * Create a new event instance.
     */
    public function __construct($eventName,$userId) //ajouter au constructeur les paramètres que vous souhaitez envoyer à votre front
    {
        $this->eventName = $eventName;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.'.$this->userId)
        ];
    }

    public function broadCastWith()
    {
        return [
            'event' => $this->eventName,
        ];
    }

    public function broadcastAs()
    {
        return 'TestEvent';
    }
}

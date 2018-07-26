<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderbookOmit implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderbooks;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($orderbooks)
    {
        $this->orderbooks = $orderbooks;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['orderbooks-channel'];
    }
}

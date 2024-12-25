<?php

namespace App\Events;

use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LivewireError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Exception $exception;

    /**
     * Create a new event instance.
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('internal'),
        ];
    }
}

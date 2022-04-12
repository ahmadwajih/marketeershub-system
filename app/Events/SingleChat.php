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
use Illuminate\Support\Facades\Log;

class SingleChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver;
    public $sender;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receiver, $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("chat.single.{$this->receiver->id}");
    }
}

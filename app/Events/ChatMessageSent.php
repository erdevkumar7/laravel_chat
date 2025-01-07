<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // \Log::info('Broadcasting on channel:', ['channel' => 'chat.' . $this->chat->vendor_id]);
        // \Log::info('Broadcasting message:', ['message' => $this->chat]);        
        return new PrivateChannel('chat.' . $this->chat->common_chat_id);
    }

    public function broadcastWith()
    {              
         return [
            'id' => $this->chat['id'],
            'user_id' => $this->chat['user_id'],
            'vendor_id' => $this->chat['vendor_id'],
            'common_chat_id' => $this->chat['common_chat_id'],
            'message' => $this->chat['message'],
            'created_at' => $this->chat['created_at'],
        ];
    }
}

<?php

namespace App\Observers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageObserver
{
    public function creating(Message $message): void
    {
        $message->user_id = auth()->id();
    }

    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        Log::info('Message created: ' . $message->id);
        broadcast(new MessageSent($message));
        Log::info('MessageSent event broadcasted for message: ' . $message->id);
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}

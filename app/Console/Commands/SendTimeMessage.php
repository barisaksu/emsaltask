<?php

namespace App\Console\Commands;

use App\Events\TimeMessageSent;
use Broadcast;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTimeMessage extends Command
{
    protected $signature = 'message:send-time';

    protected $description = 'Send a time message every 15 minutes';

    public function handle(): void
    {
        $time = Carbon::now()->format('H:i');
        $messageText = "Guk guk! saat $time";

        broadcast(new TimeMessageSent($messageText));

        $this->info('Time message sent: ' . $messageText);
    }
}

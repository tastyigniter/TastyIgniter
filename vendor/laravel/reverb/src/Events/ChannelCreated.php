<?php

namespace Laravel\Reverb\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Laravel\Reverb\Protocols\Pusher\Channels\Channel;

class ChannelCreated
{
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct(public Channel $channel)
    {
        //
    }
}

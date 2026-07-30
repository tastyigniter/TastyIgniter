<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Laravel\Reverb\Protocols\Pusher\Channels\Concerns\InteractsWithPresenceChannels;

class PresenceChannel extends PrivateChannel
{
    use InteractsWithPresenceChannels;
}

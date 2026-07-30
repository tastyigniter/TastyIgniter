<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Laravel\Reverb\Protocols\Pusher\Channels\Concerns\InteractsWithPresenceChannels;

class PresenceCacheChannel extends CacheChannel
{
    use InteractsWithPresenceChannels;
}

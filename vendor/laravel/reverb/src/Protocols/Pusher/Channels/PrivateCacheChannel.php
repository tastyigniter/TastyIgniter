<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Laravel\Reverb\Protocols\Pusher\Channels\Concerns\InteractsWithPrivateChannels;

class PrivateCacheChannel extends CacheChannel
{
    use InteractsWithPrivateChannels;
}

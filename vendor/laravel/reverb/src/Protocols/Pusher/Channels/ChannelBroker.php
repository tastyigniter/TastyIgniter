<?php

namespace Laravel\Reverb\Protocols\Pusher\Channels;

use Illuminate\Support\Str;

class ChannelBroker
{
    /**
     * Return the relevant channel instance.
     */
    public static function create(string $name): Channel
    {
        return match (true) {
            Str::startsWith($name, 'private-cache-') => new PrivateCacheChannel($name),
            Str::startsWith($name, 'presence-cache-') => new PresenceCacheChannel($name),
            Str::startsWith($name, 'cache') => new CacheChannel($name),
            Str::startsWith($name, 'private') => new PrivateChannel($name),
            Str::startsWith($name, 'presence') => new PresenceChannel($name),
            default => new Channel($name),
        };
    }
}

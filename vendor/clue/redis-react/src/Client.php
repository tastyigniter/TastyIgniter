<?php

namespace Clue\React\Redis;

use Evenement\EventEmitterInterface;
use React\Promise\PromiseInterface;

/**
 * Simple interface for executing redis commands
 *
 * @event error(Exception $error)
 * @event close()
 *
 * @event message($channel, $message)
 * @event subscribe($channel, $numberOfChannels)
 * @event unsubscribe($channel, $numberOfChannels)
 *
 * @event pmessage($pattern, $channel, $message)
 * @event psubscribe($channel, $numberOfChannels)
 * @event punsubscribe($channel, $numberOfChannels)
 */
interface Client extends EventEmitterInterface
{
    /**
     * Invoke the given command and return a Promise that will be fulfilled when the request has been replied to
     *
     * This is a magic method that will be invoked when calling any redis
     * command on this instance.
     *
     * @param string   $name
     * @param string[] $args
     * @return PromiseInterface Promise<mixed,Exception>
     */
    public function __call($name, $args);

    /**
     * end connection once all pending requests have been replied to
     *
     * @return void
     * @uses self::close() once all replies have been received
     * @see self::close() for closing the connection immediately
     */
    public function end();

    /**
     * close connection immediately
     *
     * This will emit the "close" event.
     *
     * @return void
     * @see self::end() for closing the connection once the client is idle
     */
    public function close();
}

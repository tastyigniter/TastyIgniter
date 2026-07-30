<?php

namespace Laravel\Reverb\Protocols\Pusher\Exceptions;

class RateLimitExceeded extends PusherException
{
    /**
     * The error code associated with the exception.
     *
     * @var int
     */
    protected $code = 4301;

    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message = 'Rate limit exceeded';
}

<?php

namespace Laravel\Reverb\Protocols\Pusher\Exceptions;

class ConnectionUnauthorized extends PusherException
{
    /**
     * The error code associated with the exception.
     *
     * @var int
     */
    protected $code = 4009;

    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message = 'Connection is unauthorized';
}

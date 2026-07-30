<?php

namespace Laravel\Reverb\Protocols\Pusher\Exceptions;

class ConnectionLimitExceeded extends PusherException
{
    /**
     * The error code associated with the exception.
     *
     * @var int
     */
    protected $code = 4004;

    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message = 'Application is over connection quota';
}

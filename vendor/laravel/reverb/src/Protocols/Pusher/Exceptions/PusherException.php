<?php

namespace Laravel\Reverb\Protocols\Pusher\Exceptions;

use Exception;

abstract class PusherException extends Exception
{
    /**
     * The error code associated with the exception.
     *
     * @var int
     */
    protected $code;

    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message;

    /**
     * Get the Pusher formatted error payload.
     */
    public function payload(): array
    {
        return [
            'event' => 'pusher:error',
            'data' => json_encode([
                'code' => $this->code,
                'message' => $this->message,
            ]),
        ];
    }

    /**
     * Get the encoded Pusher formatted error payload.
     */
    public function message()
    {
        return json_encode(
            $this->payload()
        );
    }
}

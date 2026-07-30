<?php

namespace Laravel\Reverb\Exceptions;

use Exception;

class InvalidOrigin extends Exception
{
    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message = 'Origin not allowed';
}

<?php

namespace Laravel\Reverb\Exceptions;

use Exception;

class InvalidApplication extends Exception
{
    /**
     * The error message associated with the exception.
     *
     * @var string
     */
    protected $message = 'Application does not exist';
}

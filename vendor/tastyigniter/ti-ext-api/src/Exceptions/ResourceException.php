<?php

declare(strict_types=1);

namespace Igniter\Api\Exceptions;

use Illuminate\Support\MessageBag;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ResourceException extends HttpException
{
    /**
     * MessageBag errors.
     */
    protected MessageBag|string $errors;

    /**
     * Create a new resource exception instance.
     */
    public function __construct(
        ?string $message = null,
        null|array|MessageBag $errors = null,
        ?Throwable $previous = null,
        array $headers = [],
        int $code = 0,
    ) {
        if (is_null($errors)) {
            $this->errors = new MessageBag;
        } else {
            $this->errors = is_array($errors) ? new MessageBag($errors) : $errors;
        }

        parent::__construct(422, $message, $previous, $headers, $code);
    }

    /**
     * Get the errors message bag.
     */
    public function getErrors(): MessageBag|string
    {
        return $this->errors;
    }

    public function errors()
    {
        return $this->errors->messages();
    }

    /**
     * Determine if message bag has any errors.
     */
    public function hasErrors(): bool
    {
        return !$this->errors->isEmpty();
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Api\Exceptions;

use Throwable;

class ValidationHttpException extends ResourceException
{
    /**
     * Create a new validation HTTP exception instance.
     */
    public function __construct(null|string|array $errors = null, ?Throwable $previous = null, array $headers = [], int $code = 0)
    {
        parent::__construct('', $errors, $previous, $headers, $code);
    }
}

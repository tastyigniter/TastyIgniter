<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts\Exceptions;

use RuntimeException;

final class ShiftException extends RuntimeException
{
    public function __construct(public readonly string $errorCode, string $message, public readonly int $status = 422)
    {
        parent::__construct($message);
    }

    public static function conflict(string $code, string $message): self
    {
        return new self($code, $message, 409);
    }

    public static function forbidden(string $code, string $message): self
    {
        return new self($code, $message, 403);
    }
}

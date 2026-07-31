<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuIntegration;

use RuntimeException;

final class IntegrationException extends RuntimeException
{
    public function __construct(public readonly string $errorCode, string $message, public readonly int $status = 422)
    {
        parent::__construct($message);
    }
}
